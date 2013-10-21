<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Inode.php';
require_once __DIR__.'/TextNode.php';

/**
 * Class \Hoathis\GraphicTools\Text.
 *
 * Concrete class that represents a svg text and 
 * primitives element for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Text  extends \Hoathis\GraphicTools\Inode {

	/**
     * Main constructor
     *
     * @param   string		$text     The content to display
     */
	function __construct($text) {

        /* 1em is hardcoded because it's absolutly 
         * nessesary to display the text. It can be overrided.
         */ 
        $this->attributes = [ 'y' => '1em' ];
        $this->elements = array();
        $textNode = new \Hoathis\GraphicTools\TextNode( $text );
        $this->addElement( $textNode );
    }
	
}

}
