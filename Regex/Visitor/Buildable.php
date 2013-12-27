<?php

namespace Hoathis\Regex\Visitor {

/**
 * Interface Hoathis\Regex\Visitor\Buildable
 *
 * Graphic buildable interface.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */
interface Buildable {

	/**
	 * Builds the graphic element in a string.
	 *
	 * @access  public
	 * @return  String
	 */
	public function build ( );

	/**
	 * Adds the lines between the in/out of the buildable element and each in/out of the childrens.
	 *
	 * @access  public
	 */
	public function addPaths ( );

	/**
	 * Adds a loop over the buildable element.
	 *
	 * @access  public
	 */
	public function addLoop ( );

	/**
	 * Adds a label to the loop.
	 *
	 * @access  private
	 */
	public function addLoopLabel ( $label );

	/**
	 * Adds a child of type buildable to the buildable element.
	 *
	 * @access  public
	 */
	public function addChild( \Hoathis\Regex\Visitor\Buildable $child);

	/**
	 * Sets the attribure of key $key with value $value
	 * 
	 * @access  public
	 */
	public function setAttribute( $key, $value );

	/**
	 * Returns the value of the attribure of key $key
	 * 
	 * @access  public
	 */
	public function getAttribute( $key );
}}
