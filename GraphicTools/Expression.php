<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Inode.php';

/**
 * Class \Hoathis\GraphicTools\Klass.
 *
 * Concrete class that represents a class.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Expression extends \Hoathis\GraphicTools\Inode {

	/**
	 * Svg representation type
	 */
	private $representation;
	
	private $height;
	private $width;
	
	/**
     * Main constructor
     *
     */
	function __construct() {
		$this->height = 0;
		$this->width = 2; // rush debug
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
		$this->width += $element->getWidth();
		$this->height += $element->getHeight();
		$this->representation->addElement( $element );
	}	
}

}
