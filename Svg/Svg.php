<?php

namespace Hoathis\Svg {
	
require_once __DIR__.'/Inode.php';


/**
 * Class \Hoathis\Svg\Svg.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Svg  extends \Hoathis\Svg\Inode {
	
	const XML_XMLNS = 'http://www.w3.org/2000/svg';
	const XML_VERSION = '1.1';
	
	/**
     * Main constructor
     */
	function __construct() {
		$this->elements = array();
		$this->attributes = array();
	}
}
}
