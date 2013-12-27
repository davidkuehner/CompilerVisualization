<?php

namespace {

from('Hoathis')
/**
 * \Hoathis\GraphicTools\Leaf
 */
->import('GraphicTools.Leaf');
}

namespace Hoathis\GraphicTools {

/**
 * Class \Hoathis\GraphicTools\Path.
 *
 * Concrete class that represents a svg path and 
 * primitives element for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */
class Path  extends \Hoathis\GraphicTools\Leaf {

	/**
	 * Main constructor
	 */
	function __construct() {

		$this->attributes = array();
		$this->elements = array();

		$this->setAttributes( array( 'style'=>'stroke:rgb(255,0,0);stroke-width:2' ));
	}
}}
