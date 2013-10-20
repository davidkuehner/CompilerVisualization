<?php

namespace Hoathis\Svg {
	
require_once __DIR__.'/Graphic.php';

/**
 * Class \Hoathis\Svg\Group.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Group extends \Hoathis\Svg\Graphic {
	
	/**
	 * List of elements in the group 
	 */
	private $elements;
	
	/**
	 * Xml attributes
	 */
	private $attributes ;
	
	/**
     * Main constructor
     */
	function __construct() {
		$this->elements = array();
		$this->attributes = array();
	}

    /**
     * Build an g element.
     *
     * @access  public
     * @param   boolean		$isRoot     Unsused, kept to match parent
     * @return  string
     */
     public function build ( $isRoot=Null ) {
		$builder = '<g'; 
		foreach ( $this->attributes as $key => $value ) {
			$builder .= ' ' . $key . '="' . $value . '"'; 
		}
		$builder .= '>';
		
		foreach ( (array)$this->elements as $element ) {
				$builder .= $element->build();
			}
			
		$builder .= '</g>';
		return $builder;
	 }
    
    /**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     * @return  string
     */
    public function addElement ( \Hoathis\Svg\Graphic $element ) {
		$this->elements[] = $element;
	}
}

}
