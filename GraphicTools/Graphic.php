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
     * Special access methods, in test
     */
    public function setAttribute( $key, $value ) {
	 $this->attributes[$key] = $value;
	}
	public function getAttribute( $key ) {
	if ( array_key_exists( $key, $this->attributes ) )
		return $this->attributes[$key];
	return null;
	}
	 
	 
	public function getWidthAndUnits() {
		return $this->getSplittedValueUnits( 'width' ); 
	}
	public function getHeightAndUnits() {
		return $this->getSplittedValueUnits( 'height' ); 
	}
	public function getWidth() {
		return $this->getValueWithoutUnits( 'width' );
	}
	public function getHeight() {
		return $this->getValueWithoutUnits( 'height' );
	}
	public function setWidth($value, $units) {
		$this->setAttribute( 'width', $value . $units );
	}
	public function setHeight($value, $units) {
		$this->setAttribute( 'height', $value . $units );
	}
	
	
	/**
	 *	Buildable unused methods	 
	 */
    public function addPaths ( ) {}

    public function addBypass ( ) {}

    public function addLoop ( ) {}

    public function addLoopLabel ( $label ) {}

    public function addChild( \Hoathis\Regex\Visitor\Buildable $child) {}
	
	/**
	 * Privates functions
	 */
	 
	private function getValueWithoutUnits( $key ) {
		$valueAndUnits = $this->getSplittedValueUnits( $key );
		if ( $valueAndUnits !== null )
			return $valueAndUnits[0];
		return 0;
	}
	
	private function getSplittedValueUnits( $key ) {
		$valueWithUnit = $this->getAttribute( $key );
		if ( $valueWithUnit !== null ){
			return $this->splitValueUnits( $valueWithUnit );	}
		return null;
	}
	
	private function splitValueUnits( $valueWithUnit ) {
		$pattern = "/^-?[0-9]+|\w+$/";
		preg_match_all($pattern, $valueWithUnit, $matches);
		$result[0] = floatval($matches[0][0]);
		$result[1] = $matches[0][1];
		return $result;
	}

}

}
