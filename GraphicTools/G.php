<?php

namespace Hoathis\GraphicTools {
	
from('Hoathis')
/**
 * \Hoathis\GraphicTools\Composite
 */
->import('GraphicTools.Composite');

/**
 * Class \Hoathis\GraphicTools\G.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class G extends \Hoathis\GraphicTools\Composite {
	
	/**
     * Main constructor
     */
	function __construct() {
		$this->elements = array();
		$this->attributes = array();
	}
}

}
