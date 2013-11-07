<?php

namespace Hoathis\Regex\Visitor\Key {
	
from('Hoathis')
/**
 * \Hoathis\GraphicTools\*
 */
->import('GraphicTools.Inode')
->import('GraphicTools.Svg');

/**
 * Class \Hoathis\GraphicTools\Klass.
 *
 * Concrete class that represents a class.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Quantification extends \Hoathis\GraphicTools\Inode {

	/**
	 * Svg representation type
	 */
	private $representation;
	
	/**
	 * Margin between the tokens in em for now
	 */
	private $margin;
	private $height;
	private $width;
	private $outY;
	
	/**
     * Main constructor
     *
     */
	function __construct() {
		$this->margin = 1;
		$this->height = 0;
		$this->width = 2; // for the mustach (a--b and e--f)
		$this->outY = 0;
		$this->representation = new \Hoathis\GraphicTools\Svg();    
    }
    
    /**
     * Override function
     * It bypass the construction of the current element to use only the
     * representation
     *
     * @access  public
     * @return  string
     *  o                       x
     *  -|----------------------->
     *   |   c--[type]--d
     *   |   |          |
     * y |a--b          e--f
     *   v
     *   
     */
     public function build () {
		 $child = $this->getElements()[0]; // first element of the quantification is the core
		 $elements = $this->getElements(); // second element is the token that define the quantification
		 $type = array_pop( $elements );
		 
		 $a = array('x' => 0, 'y' => $child->getHeight()/2 + $this->margin);
		 $b = array('x' => $this->margin, 'y' => $a['y']);
		 $c = array('x' => $b['x'], 'y' => 0);
		 $d = array('x' => $child->getWidth() + $this->margin, 'y' => 0);
		 $e = array('x' => $d['x'], 'y' => $a['y']);
		 $f = array('x' => $e['x'] + $this->margin, 'y' => $a['y']);
		 
		 $ab = new \Hoathis\GraphicTools\Line();
		 $ab->setAttributes( array( 'x1'=>$a['x'].'em', 'y1'=>$a['y'].'em', 'x2'=>$b['x'].'em', 'y2'=>$b['y'].'em' ) );
		 $this->addPath( $ab );
		 
		 $bc = new \Hoathis\GraphicTools\Line();
		 $bc->setAttributes( array( 'x1'=>$b['x'].'em', 'y1'=>$b['y'].'em', 'x2'=>$c['x'].'em', 'y2'=>$c['y'].'em' ) );
		 $this->addPath( $bc );
		 
		 $cd = new \Hoathis\GraphicTools\Line();
		 $cd->setAttributes( array( 'x1'=>$c['x'].'em', 'y1'=>$c['y'].'em', 'x2'=>$d['x'].'em', 'y2'=>$d['y'].'em' ) );
		 $this->addPath( $cd );
		 
		 $de = new \Hoathis\GraphicTools\Line();
		 $de->setAttributes( array( 'x1'=>$d['x'].'em', 'y1'=>$d['y'].'em', 'x2'=>$e['x'].'em', 'y2'=>$e['y'].'em' ) );
		 $this->addPath( $de );
		 
		 $ef = new \Hoathis\GraphicTools\Line();
		 $ef->setAttributes( array( 'x1'=>$e['x'].'em', 'y1'=>$e['y'].'em', 'x2'=>$f['x'].'em', 'y2'=>$f['y'].'em' ) );
		 $this->addPath( $ef );
		 
		 $child->setAttributes( array( 'x'=>$this->margin.'em', 'y'=>$this->margin.'em' ));
		 
		 $this->setAttributes( array( 'height'=>$this->height.'em', 'width'=>$this->width.'em' ) );
		return $this->representation->build();
		 
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 // -> go to mother class

	 public function setAttributes( array $attributes ) {
		$this->representation->setAttributes( $attributes );
	}
	
	public function getElements() {
		return $this->representation->getElements();
	}
	
    public function addElement( \Hoathis\GraphicTools\Graphic $element ) {
		$this->width += $element->getWidth() + 2*$this->margin;
		$this->height = $this->height < $element->getHeight() ? $element->getHeight() + $this->margin : $this->height;
		$this->representation->addElement( $element );
	}
	
	public function addPath( \Hoathis\GraphicTools\Graphic $path ) {
		$this->representation->addElement( $path );
	}
	
	public function getHeight(){ return $this->height; }
	public function getWidth(){ return $this->width; }
	
}

}
