<?php

namespace Hoathis\Regex\Visitor\Key {
	
from('Hoathis')
/**
 * \Hoathis\GraphicTools\*
 */
->import('GraphicTools.Inode');

/**
 * Class \Hoathis\GraphicTools\Klass.
 *
 * Concrete class that represents a class.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Klass extends \Hoathis\GraphicTools\Inode {

	/**
	 * Svg representation type
	 */
	private $representation;
	
	/**
	 * List of paths
	 */
	private $paths;
	
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
		$this->height = -$this->margin; // cause we have an extra margin at the bottom
		$this->width = $this->margin * 2; // case we have both right and left paths
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
     */
     public function build () {
		$childIndex = 0;
		
		// Distribute the token along the height
		foreach( $this->getElements() as $element ) {
			$childHeight = $element->getHeight();
			$childYPos = $childIndex*$childHeight + $childIndex*$this->margin;
			$pathYchild = $childYPos + $childHeight / 2;
			
			$pathIn = new \Hoathis\GraphicTools\Line();
			$pathOut = new \Hoathis\GraphicTools\Line();
			$pathIn->setAttributes( array( 'x1'=>'0', 'y1'=>$this->outY.'em', 'x2'=>$this->margin.'em', 'y2'=>$pathYchild.'em' ) );
			$pathOut->setAttributes( array( 'x1'=>( $this->width - $this->margin).'em', 'y1'=>$pathYchild.'em', 'x2'=>$this->width.'em', 'y2'=>$this->outY.'em' ) );
			$this->addPath( $pathIn );
			$this->addPath( $pathOut );
			
			$element->setAttributes( array( 'y'=> $childYPos . 'em', 'x'=> $this->margin.'em' ) );
			
			++$childIndex;
		}
		
		
		
		$this->setAttributes( array( 'height'=>$this->height.'em', 'width'=>$this->width.'em' ) );
		return $this->representation->build();
	 }
	 
	 /**
     * Override function
     * It passes the attribute to the svg representation
     * 
     * @see		$representation::setAttributes()
     * @access  public
     * @param   array	$attributes     "key"=>"value" as "width"=>"20px"
     */
	 public function setAttributes( array $attributes ) {
		$this->representation->setAttributes( $attributes );
	}
	
	/**
     * Override function
     * It passes the elements to the svg representation
     *
     * @access  public
     * @return  \Hoathis\GraphicTools\Graphic array
     */
	public function getElements() {
		return $this->representation->getElements();
	}
	
	/**
     * Override function
     * It adds a child svg element to the svg representation
     *
     * @access  public
     * @param   \Hoathis\GraphicTools\Graphic	$element     The child element to add.
     */
    public function addElement( \Hoathis\GraphicTools\Graphic $element ) {
		$this->width = $element->getWidth() + $this->margin * 2;
		$this->height += $element->getHeight() + $this->margin;
		$this->outY = $this->height / 2;
		$this->representation->addElement( $element );
	}
	
	public function addPath( \Hoathis\GraphicTools\Graphic $path ) {
		$this->representation->addElement( $path );
	}
	
	public function getHeight(){ return $this->height; }
	public function getWidth(){ return $this->width; }
	
}

}
