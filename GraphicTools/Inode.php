<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Graphic.php';


/**
 * Class \Hoathis\GraphicTools\Inode.
 *
 * Abstract class that represents containers elements 
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Inode extends \Hoathis\GraphicTools\Graphic {
	
	/**
	 * List of elements in the group 
	 */
	private $elements;
	
	/**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\GraphicTools\Graphic	$element     The child element to add.
     */
    public function addElement ( \Hoathis\GraphicTools\Graphic $element ) {
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
