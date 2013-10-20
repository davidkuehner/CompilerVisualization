<?php

namespace Hoathis\Svg {

/**
 * Class \Hoathis\Svg\Inode.
 *
 * Abstract class that represents containers elements 
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Inode extends \Hoathis\Svg\Graphic {
	
	/**
	 * List of elements in the group 
	 */
	private $elements;
	
	/**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     */
    public function addElement ( \Hoathis\Svg\Graphic $element ) {
		$this->elements[] = $element;
	}
	
	/**
     * Build an g element.
     *
     * @access  public
     * @param   string		$isRoot     Unsused, kept to match parent
     * @return  string
     */
     public function build () {
		 		
		// Finds the class name without namespace
		$className = strtolower( get_class( $this ) );
		preg_match( '/\w+$/', $className, $match );
		$className = $match[0];
		
		$builder = '<' . $className;

		// Adds every attributes in the tag
		foreach ( $this->attributes as $key => $value ) {
			$builder .= ' ' . $key . '="' . $value . '"'; 
		}
		$builder .= '>';
		
		// Adds children elements
		foreach ( (array)$this->elements as $element ) {
				$builder .= $element->build();
			}
		
		// Close the current element with the closer tag
		$builder .= '</' . $className . '>';
		return $builder;
	 }
	
}

}
