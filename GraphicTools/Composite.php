<?php

namespace {

from('Hoathis')
/**
 * \Hoathis\GraphicTools\Graphic
 */
->import('GraphicTools.Graphic')
->import('Regex.Visitor.Buildable');
}

namespace Hoathis\GraphicTools {

/**
 * Class \Hoathis\GraphicTools\Composite.
 *
 * Abstract class that represents composite elements 
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Composite extends Graphic {
	
	/**
	 * List of elements in the group 
	 */
	protected $elements;
	
	/**
	 * Margin between the elements in the group 
	 */
	private $margin;
	
	private $isLayoutVertical;
	private $isLayoutHorizontal;
	private $isLayoutWrapping;
	private $hasPath;
	private $hasBypass;
	private $hasLoop;
	private $hasLoopLabel;
	private $loopLabel;
	private $hasComment;
	private $comment;
	private $hasCondition;
	
	/**
     * Main constructor
     */
	function __construct() {
		parent::__construct();
		
		// Default initialisation
		$this->elements = array();
		$this->isLayoutVertical = false;
		$this->isLayoutHorizontal  = false;
		$this->isLayoutWrapping = false;
		$this->hasPath  = false;
		$this->hasBypass  = false;
		$this->hasLoop  = false;
		$this->hasLoopLabel  = false;
		$this->loopLabel = '';
		$this->hasComment = false;
		$this->comment = '';
		$this->hasCondition = false;
		$this->margin = 0;
	}
	
	
	
	/**
     * Adds a child of type buildable to the buildable element.
     *
     * @access  public
     */
    public function addChild( \Hoathis\Regex\Visitor\Buildable $child) {
		
		// if we have two consecutive token children -> concat them
		$previous = end($this->elements);
		if( ( $this->getAttribute( 'class' ) == 'range' || $this->getAttribute( 'class' ) == 'concatenation' )
			&& $child->getAttribute( 'class' ) == 'token'
			&& $previous != FALSE
			&& $previous->getAttribute( 'class' ) == 'token' ) {
				
			// simple concatenation
			$prevText = end( $previous->getElements() );
			$prevRect = reset( $previous->getElements() );
			$prevRectWidth = $prevRect->getWidth(); // store for later
			$curText = end( $child->getElements() );
			$newText = $prevText->getText();
			// if current context is range
			if ( $this->getAttribute( 'class' ) == 'range' ) 
				$newText .= '-';
			$newText .= $curText->getText();
			$prevText->setText( $newText );
			// adapt the widths
			$prevRect->setWidth( $prevText->getWidth() + SvgCreator::MARGIN * 2 );
			$this->setWidth( $this->getWidth() - $prevRectWidth + $prevRect->getWidth() );
			$previous->setWidth( $prevRect->getWidth() );
		
		// if not, do standard work
		} else {
			
			if( $this->isLayoutVertical ) {
				
				$this->setHeight( $this->getHeight() + $child->getHeight() + $this->margin );
				if ( $this->getWidth() < $child->getWidth() + $this->margin * 2 ) {
					//$this->setWidthRecursively( $child->getWidth()  );
					$this->setWidth( $child->getWidth() + $this->margin * 2);
				} else {
					//$child->setWidthRecursively( $this->getWidth() -  $this->margin * 2 );
				}
				
				
			} else if( $this->isLayoutHorizontal ) {
				
				if ( $this->getHeight() < $child->getHeight() + $this->margin * 2 ) {
					$this->setHeight( $child->getHeight() + $this->margin * 2);
				}
				$this->setWidth( $this->getWidth() + $child->getWidth() + $this->margin );
				
			} else if( $this->isLayoutWrapping ) {
	
				if ( $this->getHeight() < $child->getHeight() ) {
					$this->setHeight( $child->getHeight() + $this->margin * 2);
				}
				if ( $this->getWidth() < $child->getWidth() ) {
					$this->setWidth( $child->getWidth() + $this->margin * 2);
				}
				
			}
			$this->elements[] = $child;
		}
	}
		
	/**
     * Adds a child to the svg element without layout context.
     *
     * @access  public
     * @param   \Hoathis\GraphicTools\Graphic	$element     The child element to add.
     */
    private function addElement( Graphic $element ) {
		$this->elements[] = $element;
	}
	
	/**
     * Returns the list of elements
     *
     * @access  public
     * @return  \Hoathis\GraphicTools\Graphic array
     */
	public function getElements () {
		return $this->elements;
	}
	
	/**
     * Builds an composite element.
     *
     * @access  public
     * @return  string
     */
     public function build () {
		 		
		// Finds the class name without namespace
		$className = strtolower( get_class( $this ) );
		// Finds the class name without namespace
		$className = strtolower( get_class( $this ) );
		// Gets the name without the namespace
		preg_match( '/\w+$/', $className, $match );
		$className = $match[0];
		
		
		$builder = $this->buildOpenerTag( $className );
		
		// Constructs a if then else structure with children
		if( $this->hasCondition ) {
			$this->buildCondition();
		}
		
		// Sets (x;y) position to the child according to the layout
		// And adds paths to each children if asked
		if( $this->isLayoutVertical ) {
			$this->buildVertivalLayout();
		}
		else if( $this->isLayoutHorizontal ) {
			$this->buildHorizontalLayout();
		}
		
		
		// Constructs a loop, can be bypass or loop. It's defined by
		// the token type of the second child.
		if( $this->hasLoop ) {
			$this->buildLoopAndBypass();
		}
		
		// Constructs a loop, can be bypass or loop. It's defined by
		// the token type of the second child.
		if( $this->hasBypass ) {
			$this->buildBypass();
		}
		
		// Adds comment label
		if( $this->hasComment ) {
			$this->buildComment();
		}
		
		// Adds children elements
		foreach ( (array)$this->elements as $element ) {
				$builder .= $element->build();
			}
			
			
		$builder .= $this->buildCloserTag( $className );
		//$builder .= "<!-- debug: " . $className. " -->";
		
		return $builder;
	 }
	 
	 public function setWidthRecursively( $value ) {
		 $this->setWidth( $value );
		 foreach( (array)$this->elements as $child ) {
			$child->setWidthRecursively( $value );
		 }
	 }
	 
	 private function buildOpenerTag( $className ) {

		$builder = '<' . $className;

		// Adds every attributes in the tag
		foreach ( $this->attributes as $key => $value ) {
			$builder .= ' ' . $key . '="' . $value . '"'; 
		}
		$builder .= '>';
		
		return $builder;
	 }
	 
	 private function buildCloserTag( $className ) {
		 // Close the current element with the closer tag
		return '</' . $className . '>';
	 }
	 
	 private function buildVertivalLayout() {
		 $childIndex = 0;
		 $childsHeightSum = 0;

		// Distribute the token along the height
		foreach( $this->getElements() as $child ) {
			$childWidth = $child->getWidth();
			$childHeight = $child->getHeight();
			
			$childYPos = $childsHeightSum + $childIndex*$this->margin;
			$childsHeightSum += $childHeight;

			$childIndention  = $this->getWidth() - $child->getWidth() - 2*$this->margin; // The diff between the child width and the parent width, used to center the child
			
			// Adds path if nessesary
			if( $this->hasPath ) {

				$curveOffset = 10; // adjust the path curve
				
				// Path in points
				$a = array('x' => 0, 'y' => $this->getHeight() / 2);
				$b = array('x' => $this->margin, 'y' => $a['y']);
				$c = array('x' => $a['x'], 'y' => $childYPos + $childHeight / 2);
				$d = array('x' => $b['x'], 'y' => $c['y']);
				
				// Path out points
				$e = array('x' => $this->getWidth() - $this->margin, 'y' => $childYPos + $childHeight / 2);
				$f = array('x' => $this->getWidth(), 'y' => $e['y']);
				$g = array('x' => $e['x'], 'y' => $this->getHeight() / 2);
				$h = array('x' => $f['x'], 'y' => $g['y']);
				
				$pathIn = new \Hoathis\GraphicTools\Path();
				$pathOut = new \Hoathis\GraphicTools\Path();
				
				$pathIn->setAttributes( array( 'fill' => 'none', 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
				$pathIn->setAttributes( array( 'd' 	=>  ' M'.$a['x'].','.$a['y'] 
													.	' C'.($b['x']-$curveOffset).','.$b['y'] . ' ' . ($c['x']+$curveOffset).','.$c['y'] . ' ' . $d['x'].','.$d['y'] ));
				$pathOut->setAttributes( array( 'fill' => 'none', 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
				$pathOut->setAttributes( array( 'd' 	=>  ' M'.$e['x'].','.$e['y'] 
														.	' C'.($f['x']-$curveOffset).','.$f['y'] . ' ' . ($g['x']+$curveOffset).','.$g['y'] . ' ' . $h['x'].','.$h['y'] ));
													
				$this->addElement( $pathIn );
				$this->addElement( $pathOut );
				
				if( $childIndention > 0) {
				$lineIn = new \Hoathis\GraphicTools\Line();
				$lineOut = new \Hoathis\GraphicTools\Line();
				
				$lineIn->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2'));
				$lineIn->setAttributes( array( 'x1'=>$d['x'], 'y1'=>$d['y'], 'x2'=>$d['x']+$childIndention/2, 'y2'=> $d['y'] ));
				
				$lineOut->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2'));
				$lineOut->setAttributes( array( 'x1'=>$e['x'], 'y1'=>$e['y'], 'x2'=>$e['x']-$childIndention/2, 'y2'=> $e['y'] ));
				
				$this->addElement( $lineIn );
				$this->addElement( $lineOut );
				}
				
			}
			
			
			
			
			$child->setAttributes( array( 'y'=> $childYPos, 'x'=> ( $this->margin + ($childIndention/2) ) ) );
			
			++$childIndex;
		}
	 }
	 
	 private function buildHorizontalLayout() {
		$childIndex = 0;
		$offset = 0; // width took by the previous element on x

		// Distribute the token along the height
		foreach( $this->getElements() as $child ) {
			$childWidth = $child->getWidth();
			$childXPos = $offset + $childIndex*$this->margin;
			
			$child->setAttributes( array( 'y'=> $this->getHeight()/2 - $child->getHeight()/2, 'x'=> $childXPos ) );
			
			++$childIndex;
			$offset += $childWidth + $this->margin;
		}
	 }
	 
	 private function buildCondition() {
		// We have 3 childre in condition structure : if then else
		
		$ifStatement = $this->elements[0]; // if is child[0]
		$thenStatement = $this->elements[1]; // then is child[1]
		$elseStatement = $this->elements[2]; // else is child[2]
		
		unset($this->elements[1]);
		unset($this->elements[2]);
		
		$thenElse = new \Hoathis\GraphicTools\Svg();
		$thenElse->setVerticalLayout();
		$thenElse->addPaths();
		$thenElse->setMargin( SvgCreator::BIG_MARGIN );
		$thenElse->setHeight( -SvgCreator::BIG_MARGIN );
		$thenElse->addChild($thenStatement);
		$thenElse->addChild($elseStatement);
		
		$this->addChild($thenElse);
		$this->setWidth( $this->getWidth() + $this->margin*2  );
	 }
	 
	 private function buildLoopAndBypass() {
		$label = $this->elements[1];
		
		if( is_a($label, '\Hoathis\GraphicTools\NullNode') ) {
			$this->buildBypass();
		} else if ( preg_match("/^zero or one/", $label->getText()) ) {
			$this->buildBypass();
		} else if ( preg_match("/^zero or/", $label->getText()) ) {
			$this->buildBypass();
			$this->buildLoop();
		} else {
			$this->buildLoop();
		}
		
		
		
	 }
	 
	 private function buildBypass() {
		$child = $this->elements[0]; // first element of the quantification is the core
		$label = $this->elements[1]; // second element is the token that define the quantification
				
		$p = array('x' => $this->margin, 'y' => $child->getHeight()/2 + $this->margin);  //in
		$q = array('x' => $child->getWidth() + $this->margin, 'y' => $p['y']); // out
		
		$a = array('x' => 0, 'y' => $p['y']);
		$b = array('x' => $p['x']/2, 'y' => $p['y']);
		$c = array('x' => $b['x'], 'y' => $p['y']+$p['x']/2);
		
		$d = array('x' => $b['x'], 'y' => $child->getHeight() + $this->margin);
		$e = array('x' => $d['x'], 'y' => $d['y']+$this->margin/2);
		$f = array('x' => $p['x'], 'y' => $e['y']);
		
		$g = array('x' => $q['x'], 'y' => $f['y']);
		$h = array('x' => $g['x'] + $this->margin/2, 'y' => $f['y']);
		$i = array('x' => $h['x'], 'y' => $d['y']);
		
		$j = array('x' => $h['x'], 'y' => $c['y']);
		$k = array('x' => $h['x'], 'y' => $a['y']);
		$l = array('x' => $h['x']+$this->margin/2, 'y' => $a['y']);
		
		$pa = new \Hoathis\GraphicTools\Line();
		$pa->setAttributes( array( 'x1'=>$p['x'], 'y1'=>$p['y'], 'x2'=>$a['x'], 'y2'=>$a['y'] ) );
		$pa->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$this->addElement( $pa );
		
		$path = new \Hoathis\GraphicTools\Path();
		$path->setAttributes( array( 'fill' => 'none', 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$path->setAttributes( array( 'd' => ' M'.$a['x'].','.$a['y'] 
										.	' Q'.$b['x'].','.$b['y'] . ' ' . $c['x'].','.$c['y'] 
										.	' L'.$d['x'].','.$d['y']
										.	' Q'.$e['x'].','.$e['y'] . ' ' . $f['x'].','.$f['y'] 
										.	' L'.$g['x'].','.$g['y']
										.	' Q'.$h['x'].','.$h['y'] . ' ' . $i['x'].','.$i['y'] 
										.	' L'.$j['x'].','.$j['y']
										.	' Q'.$k['x'].','.$k['y'] . ' ' . $l['x'].','.$l['y']
										) );

		$arrowRight = new \Hoathis\GraphicTools\Path();
		$arrowRight->setAttributes( array( 'd' => 'M'.($l['x']/2).','.$e['y'] . '  l-10,5 l0,-10 ', 'style' => 'fill:'.SvgCreator::ARROW_COLOR ));
		
		$this->addElement( $path );
		$this->addElement( $arrowRight );
		
		$lq = new \Hoathis\GraphicTools\Line();
		$lq->setAttributes( array( 'x1'=>$l['x'], 'y1'=>$l['y'], 'x2'=>$q['x'], 'y2'=>$q['y'] ) );
		$lq->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$this->addElement( $lq );
		
		$child->setAttributes( array( 'x'=>$this->margin, 'y'=>$this->margin ));
		$label->setAttributes( array( 'x'=>$child->getWidth()/2+$this->margin, 'y'=>$this->margin/2 ));
	 }
	 
	 private function buildLoop() {
		$child = $this->elements[0]; // first element of the quantification is the core
		$label = $this->elements[1]; // second element is the token that define the quantification
				
		$p = array('x' => 0, 'y' => $child->getHeight()/2 + $this->margin);  //in
		
		$a = array('x' => $this->margin, 'y' => $p['y']);
		$b = array('x' => $a['x']/2, 'y' => $p['y']);
		$c = array('x' => $a['x']/2, 'y' => $p['y']-$a['x']/2);
		$d = array('x' => $a['x']/2, 'y' => $a['x']/2);
		$e = array('x' => $a['x']/2, 'y' => 1);
		$f = array('x' => $a['x'], 'y' => 1);
		$g = array('x' => $child->getWidth() + $this->margin, 'y' => 1);
		$h = array('x' => $g['x'] + $this->margin/2, 'y' => 1);
		$i = array('x' => $h['x'], 'y' => $d['y']);
		$j = array('x' => $h['x'], 'y' => $c['y']);
		$k = array('x' => $h['x'], 'y' => $a['y']);
		$l = array('x' => $g['x'], 'y' => $a['y']);
		
		$q = array('x' => $child->getWidth() + $this->margin * 2, 'y' => $p['y']); // out
		
		$pa = new \Hoathis\GraphicTools\Line();
		$pa->setAttributes( array( 'x1'=>$p['x'], 'y1'=>$p['y'], 'x2'=>$a['x'], 'y2'=>$a['y'] ) );
		$pa->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$this->addElement( $pa );
		
		$path = new \Hoathis\GraphicTools\Path();
		$path->setAttributes( array( 'fill' => 'none', 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$path->setAttributes( array( 'd' => ' M'.$a['x'].','.$a['y'] 
										.	' Q'.$b['x'].','.$b['y'] . ' ' . $c['x'].','.$c['y'] 
										.	' L'.$d['x'].','.$d['y']
										.	' Q'.$e['x'].','.$e['y'] . ' ' . $f['x'].','.$f['y'] 
										.	' L'.$g['x'].','.$g['y']
										.	' Q'.$h['x'].','.$h['y'] . ' ' . $i['x'].','.$i['y'] 
										.	' L'.$j['x'].','.$j['y']
										.	' Q'.$k['x'].','.$k['y'] . ' ' . $l['x'].','.$l['y']
										) );

		$arrowUp = new \Hoathis\GraphicTools\Path();
		$arrowUp->setAttributes( array( 'd' => 'M'.$h['x'].','.$k['y']/2 . '  l5,10 l-10,0 ', 'style' => 'fill:'.SvgCreator::ARROW_COLOR ));

		$arrowDown = new \Hoathis\GraphicTools\Path();
		$arrowDown->setAttributes( array( 'd' => 'M'.$e['x'].','.$b['y']/2 . '  l5,-10 l-10,0 ', 'style' => 'fill:'.SvgCreator::ARROW_COLOR ));
		
		$this->addElement( $path );
		$this->addElement( $arrowUp );
		$this->addElement( $arrowDown );
		
		$lq = new \Hoathis\GraphicTools\Line();
		$lq->setAttributes( array( 'x1'=>$l['x'], 'y1'=>$l['y'], 'x2'=>$q['x'], 'y2'=>$q['y'] ) );
		$lq->setAttributes( array( 'style'=>'stroke:'.SvgCreator::PATH_COLOR.'; stroke-width:2' ));
		$this->addElement( $lq );
		
		$child->setAttributes( array( 'x'=>$this->margin, 'y'=>$this->margin ));
		$label->setAttributes( array( 'x'=>$child->getWidth()/2+$this->margin, 'y'=>$this->margin/2 ));
		
	 }
	 
	 private function buildComment() {
		 $comment = new \Hoathis\GraphicTools\Text( $this->comment );
		 $comment->setAttributes( array( 'font-size' => ( SvgCreator::FONT_SIZE_COMMENT )  ) );
		 $comment->setAttributes( array( 'x'=>'0', 'y'=>'10'));
		 $this->addElement ( $comment );
	 }	
	 
	 /**
	  * Adds if else then structure when the node is build
	  */
	 public function addCondition() {
		 $this->hasCondition = true;
	 }
	
	 /**
	  * Adds a comment to the element
	  * @access  public
	  */
	 public function addComment ( $value ) {
		$this->hasComment = true;
		$this->comment = $value;
	 }
	
	 /**
     * Adds the lines between the in/out of the buildable element and each in/out of the childrens.
     *
     * @access  public
     */
    public function addPaths ( ) {
			$this->hasPath = true;
		}
    
    /**
     * Adds a bypass to the buildable element
     *
     * @access  public
     */
    public function addBypass ( ) {
			$this->hasBypass = true;
		}
    
    /**
     * Adds a loop over the buildable element.
     *
     * @access  public
     */
    public function addLoop ( ) {
			$this->hasLoop = true;
		}
    
    /**
     * Adds a label to the loop.
     *
     * @access  private
     */
    public function addLoopLabel ( $label ) {
			$this->hasLoopLabel = true;
			$this->loopLabel = $label;
		}
    
    /**
     *	Sets the margin attribute 
     */
	 public function setMargin( $margin ) {
		 $this->margin = $margin;
	 }
	 
	 /**
	  * Sets the layout orientation to vertical
	  */
	public function setVerticalLayout( ) {
		$this->isLayoutVertical = true;
		$this->isLayoutHorizontal = false;
		$this->isLayoutWrapping = false;
	}
	 /**
	  * Sets the layout orientation to horizontal
	  */
	public function setHorizontalLayout( ) {
		$this->isLayoutVertical = false;
		$this->isLayoutHorizontal = true;
		$this->isLayoutWrapping = false;
	}
	/**
	  * Sets the layout to wrapping content
	  */
	public function setWrappingLayout( ) {
		$this->isLayoutVertical = false;
		$this->isLayoutHorizontal = false;
		$this->isLayoutWrapping = true;
	}
}

}
