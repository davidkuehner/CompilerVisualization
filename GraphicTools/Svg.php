<?php

namespace {

from('Hoathis')
/**
 * \Hoathis\GraphicTools\Composite
 */
->import('GraphicTools.Composite');
}

namespace Hoathis\GraphicTools {

/**
 * Class \Hoathis\GraphicTools\Svg.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */
class Svg  extends \Hoathis\GraphicTools\Composite {

	const XML_XMLNS = 'http://www.w3.org/2000/svg';
	const XML_VERSION = '1.1';
	
	/**
	 * Adds standard reference attribute
	 *
	 * @access public
	 */
	public function addStandard( ) {
		$this->setAttribute( 'xmlns', self::XML_XMLNS );
	}
	
	/**
	 * Adds standard version attribute
	 *
	 * @access public
	 */
	public function addVersion( ) {
		$this->setAttribute( 'version', self::XML_VERSION );
	}
	
}}
