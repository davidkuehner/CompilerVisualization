<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Leaf.php';

/**
 * Class \Hoathis\GraphicTools\Rect.
 *
 * Concrete class that represents a svg rect and 
 * primitives element for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Rect  extends \Hoathis\GraphicTools\Leaf {

	/**
     * Main constructor
     */
	function __construct() {

        $this->attributes = array();
        $this->elements = array();
    }
	
}

}
