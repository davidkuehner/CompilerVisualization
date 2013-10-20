<?php

namespace Hoathis\Svg {
	
require_once __DIR__.'/Graphic.php';
require_once __DIR__.'/Inode.php';

/**
 * Class \Hoathis\Svg\Group.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class G extends \Hoathis\Svg\Inode {
	
	/**
     * Main constructor
     */
	function __construct() {
		$this->elements = array();
		$this->attributes = array();
	}
}

}
