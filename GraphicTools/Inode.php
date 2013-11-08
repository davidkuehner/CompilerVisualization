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

abstract class Inode extends Graphic implements \Hoathis\Regex\Visitor\Buildable {
	
	/**
	 * List of elements in the group 
	 */
	private $elements;
	
	/**
     * Main constructor
     */
	function __construct() {
		parent::__construct();
		$this->elements = array();
	}
	
	/**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\GraphicTools\Graphic	$element     The child element to add.
     */
    public function addElement( Graphic $element ) {
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
	 
	 
	 
	 
	 
	 /**
     * Adds the lines between the in/out of the buildable element and each in/out of the childrens.
     *
     * @access  public
     */
    public function addPaths ( ) {}
    
    /**
     * Adds a bypass to the buildable element
     *
     * @access  public
     */
    public function addByPath ( ) {}
    
    /**
     * Adds a loop over the buildable element.
     *
     * @access  public
     */
    public function addLoop ( ) {}
    
    /**
     * Adds a label to the loop.
     *
     * @access  private
     */
    public function addLoopLabel ( ) {}
    
    /**
     * Adds a child of type buildable to the buildable element.
     *
     * @access  public
     */
    public function addChild( \Hoathis\Regex\Visitor\Buildable $child) {}
	 
	
}

}
