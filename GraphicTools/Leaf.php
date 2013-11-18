<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Graphic.php';


/**
 * Class \Hoathis\GraphicTools\Leaf.
 *
 * Abstract class that represents primitives elements 
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Leaf extends \Hoathis\GraphicTools\Graphic {

	/**
     * Builds an leaf element.
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
		$builder .= ' />';
		
		return $builder;
	 }
	 
	 public function setWidthRecursively( $value, $unit ) {
		 $this->setWidth( $value, $unit );
	 }

}

}
