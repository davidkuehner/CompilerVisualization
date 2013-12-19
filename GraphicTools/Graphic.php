<?php

namespace Hoathis\GraphicTools {

/**
 * Class \Hoathis\GraphicTools\Graphic.
 *
 * Abstract class that represents both primitives and 
 * containers elements for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Graphic  implements \Hoathis\Regex\Visitor\Buildable {
	
	const XML_STANDALONE_VERSION = '<?xml version="1.0" standalone="no"?>';
	const XML_STANDALONE_DTD = '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
	
	/**
	 * Xml attributes
	 */
	protected $attributes ;
	
	function __construct ( ) {
		$this->attributes = array();
	}

    /**
     * Build an svg element.
     *
     * @access  public
     * @return  string
     */
    abstract public function build ();
    
    /**
     * Add an attribute.
     *
     * @access  public
     * @param   array	$attributes     "key"=>"value" as "width"=>"20px"
     */
    public function setAttributes ( array $attributes ) {
		$this->attributes = array_merge($this->attributes, $attributes);
	}
	
	 /**
     * Debug function
     */
	public function getAttributes() {
		return $this->attributes;
	}
	
	/**
     * Special access methods
     */
    public function setAttribute( $key, $value ) {
	 $this->attributes[$key] = $value;
	}
	public function getAttribute( $key ) {
	if ( array_key_exists( $key, $this->attributes ) )
		return $this->attributes[$key];
	return null;
	}
	 
	public function getWidth() {
		return $this->getAttribute( 'width' );
	}
	public function getHeight() {
		return $this->getAttribute( 'height' );
	}
	public function setWidth( $value ) {
		$this->setAttribute( 'width', $value );
	}
	public function setHeight( $value ) {
		$this->setAttribute( 'height', $value );
	}
	
	
	/**
	 *	Buildable unused methods	 
	 */
    public function addPaths ( ) {}

    public function addBypass ( ) {}

    public function addLoop ( ) {}

    public function addLoopLabel ( $label ) {}

    public function addChild( \Hoathis\Regex\Visitor\Buildable $child) {}

}

}
