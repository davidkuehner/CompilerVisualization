<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Graphic.php';


/**
 * Class \Hoathis\GraphicTools\TextNode.
 *
 * Concret class that represent the string in a svg text element.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class TextNode extends \Hoathis\GraphicTools\Graphic {
	
	/**
	 * Text content
	 */
	private $text ;
	
	
	/**
     * Main constructor
     */
	function __construct( $text ) {
		$this->text = $text;
	}
	
	/**
     * Build an text string.
     *
     * @access  public
     * @return  string
     */
     public function build () {
		 return $this->text;
	 }
	
}

}
