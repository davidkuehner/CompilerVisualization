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
 * Class \Hoathis\GraphicTools\Inode.
 *
 * Abstract class that represents composite elements 
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Inode extends Graphic {
	
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
			&&$child->getAttribute( 'class' ) == 'token'
			&& $previous != FALSE
			&& $previous->getAttribute( 'class' ) == 'token' ) {
				
			// simple concatenation
			$prevText = end( $previous->getElements() );
			$curText = end( $child->getElements() );
			$newText = $prevText->getText();
			// if current context is range
			if ( $this->getAttribute( 'class' ) == 'range' ) 
				$newText .= '-';
			$newText .= $curText->getText();
			$prevText->setText( $newText );
		
		// if not, do standard work
		} else {
			
			if( $this->isLayoutVertical ) {
				
				$this->setHeight( $this->getHeight() + $child->getHeight() + $this->margin, SvgCreator::UNITS );
				if ( $this->getWidth() < $child->getWidth() ) {
					$this->setWidth( $child->getWidth() + $this->margin * 2, SvgCreator::UNITS);
				}
				
			} else if( $this->isLayoutHorizontal ) {
				
				if ( $this->getHeight() < $child->getHeight() ) {
					$this->setHeight( $child->getHeight() + $this->margin * 2, SvgCreator::UNITS);
				}
				$this->setWidth( $this->getWidth() + $child->getWidth() + $this->margin, SvgCreator::UNITS );
				
			} else if( $this->isLayoutWrapping ) {
	
				if ( $this->getHeight() < $child->getHeight() ) {
					$this->setHeight( $child->getHeight() + $this->margin * 2, SvgCreator::UNITS);
				}
				if ( $this->getWidth() < $child->getWidth() ) {
					$this->setWidth( $child->getWidth() + $this->margin * 2, SvgCreator::UNITS);
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
     * Builds an inode element.
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
		
		
		// Sets (x;y) position to the child according to the layout
		// And adds paths to each children if asked
		if( $this->isLayoutVertical ) {
			$this->buildVertivalLayout();
		}
		else if( $this->isLayoutHorizontal ) {
			$this->buildHorizontalLayout();
		}
		
		
		// Construct a loop, can be bypass or loop. It's defined by
		// the token type of the second child.
		if( $this->hasLoop ) {
			$this->buildLoop();
		}
		
		// Adds children elements
		foreach ( (array)$this->elements as $element ) {
				$builder .= $element->build();
			}
			
			
		$builder .= $this->buildCloserTag( $className );
		//$builder .= "<!-- debug: " . $className. " -->";
		
		return $builder;
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

		// Distribute the token along the height
		foreach( $this->getElements() as $element ) {
			$childHeight = $element->getHeight();
			$childYPos = $childIndex*$childHeight + $childIndex*$this->margin;
			$u = SvgCreator::UNITS; // units
			
					
			// Adds path if nessesary
			if( $this->hasPath ) {
				$pathYchild = $childYPos + $childHeight / 2;
				$outY = $this->getHeight() / 2;

				$pathIn = new \Hoathis\GraphicTools\Line();
				$pathOut = new \Hoathis\GraphicTools\Line();
				$pathIn->setAttributes( array( 'x1'=>'0', 'y1'=>$outY.$u, 'x2'=>$this->margin.$u, 'y2'=>$pathYchild.$u ) );
				$pathOut->setAttributes( array( 'x1'=>( $this->getWidth() - $this->margin).$u, 'y1'=>$pathYchild.$u, 'x2'=>$this->getWidth().$u, 'y2'=>$outY.$u ) );
				$this->addElement( $pathIn );
				$this->addElement( $pathOut );
			}
			
			$element->setAttributes( array( 'y'=> $childYPos . $u, 'x'=> $this->margin.$u ) );
			
			++$childIndex;
		}
	 }
	 
	 private function buildHorizontalLayout() {
		$childIndex = 0;
		$offset = 0; // width took by the previous element on x

		// Distribute the token along the height
		foreach( $this->getElements() as $element ) {
			$childWidth = $element->getWidth();
			$childXPos = $offset + $childIndex*$this->margin;
			$u = SvgCreator::UNITS; // units
			
			$element->setAttributes( array( 'y'=> $this->getHeight()/2 - $element->getHeight()/2 . $u, 'x'=> $childXPos . $u ) );
			
			++$childIndex;
			$offset += $childWidth + $this->margin;
		}
	 }
	 
	 private function buildLoop() {
		$child = $this->elements[0]; // first element of the quantification is the core
		$label = $this->elements[1]; // second element is the token that define the quantification

		$u = SvgCreator::UNITS; // units
				
		$a = array('x' => 0, 'y' => $child->getHeight()/2 + $this->margin);
		$b = array('x' => $this->margin, 'y' => $a['y']);
		$c = array('x' => $b['x'], 'y' => 0);
		$d = array('x' => $child->getWidth() + $this->margin, 'y' => 0);
		$e = array('x' => $d['x'], 'y' => $a['y']);
		$f = array('x' => $e['x'] + $this->margin, 'y' => $a['y']);
		
		$ab = new \Hoathis\GraphicTools\Line();
		$ab->setAttributes( array( 'x1'=>$a['x'].$u, 'y1'=>$a['y'].$u, 'x2'=>$b['x'].$u, 'y2'=>$b['y'].$u ) );
		$this->addElement( $ab );
		
		$bc = new \Hoathis\GraphicTools\Line();
		$bc->setAttributes( array( 'x1'=>$b['x'].$u, 'y1'=>$b['y'].$u, 'x2'=>$c['x'].$u, 'y2'=>$c['y'].$u ) );
		$this->addElement( $bc );
		
		$cd = new \Hoathis\GraphicTools\Line();
		$cd->setAttributes( array( 'x1'=>$c['x'].$u, 'y1'=>$c['y'].$u, 'x2'=>$d['x'].$u, 'y2'=>$d['y'].$u ) );
		$this->addElement( $cd );
		
		$de = new \Hoathis\GraphicTools\Line();
		$de->setAttributes( array( 'x1'=>$d['x'].$u, 'y1'=>$d['y'].$u, 'x2'=>$e['x'].$u, 'y2'=>$e['y'].$u ) );
		$this->addElement( $de );
		
		$ef = new \Hoathis\GraphicTools\Line();
		$ef->setAttributes( array( 'x1'=>$e['x'].$u, 'y1'=>$e['y'].$u, 'x2'=>$f['x'].$u, 'y2'=>$f['y'].$u ) );
		$this->addElement( $ef );
		
		$child->setAttributes( array( 'x'=>$this->margin.$u, 'y'=>$this->margin.$u ));
		$label->setAttributes( array( 'x'=>$this->margin*2+$child->getWidth() . $u, 'y'=>$this->margin.$u ));
		
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
