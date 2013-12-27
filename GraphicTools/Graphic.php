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

	/**
	 * Main constructor
	 */
	function __construct ( ) {
		$this->attributes = array();
	}

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\build
	 */
	abstract public function build ();

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\setAttribute
	 */
	public function setAttribute( $key, $value ) {
	$this->attributes[$key] = $value;
	}

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\getAttribute
	 */
	public function getAttribute( $key ) {
		if ( array_key_exists( $key, $this->attributes ) )
			return $this->attributes[$key];
		return null;
	}

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\addPaths
	 */
	public function addPaths ( ) { }

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\addLoop
	 */
	public function addLoop ( ) { }

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\addLoopLabel
	 */
	public function addLoopLabel ( $label ) { }

	/**
	 * @see Hoathis\Regex\Visitor\Buildable\addChild
	 */
	public function addChild( \Hoathis\Regex\Visitor\Buildable $child) { }

	/**
	 * Add a list of attributes.
	 *
	 * @access public
	 * @param  array  $attributes  "key"=>"value" as "width"=>"20"
	 */
	public function setAttributes ( array $attributes ) {
		$this->attributes = array_merge($this->attributes, $attributes);
	}

	/**
	 * Gets all the attributes.
	 * 
	 * @access public
	 * @return array The list of attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Gets the width attribute
	 * 
	 * @access public
	 * @return string the width
	 */
	public function getWidth() {
		return $this->getAttribute( 'width' );
	}

	/**
	 * Gets the height attribute
	 * 
	 * @access public
	 * @return string the height
	 */
	public function getHeight() {
		return $this->getAttribute( 'height' );
	}

	/**
	 * Sets the width attribute
	 * 
	 * @access public
	 * @param  string The width
	 */
	public function setWidth( $value ) {
		$this->setAttribute( 'width', $value );
	}

	/**
	 * Sets the height attribute
	 * 
	 * @access public
	 * @param  string The height
	 */
	public function setHeight( $value ) {
		$this->setAttribute( 'height', $value );
	}
}}
