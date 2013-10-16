<?php

namespace Hoathis\Svg {
	
include __DIR__.'/Graphic.php';

/**
 * Class \Hoathis\Svg\Text.
 *
 * Concrete class that represents a text element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Text  extends Graphic {
	
	/**
	 * Text content 
	 */
	private $text ;
	private $attributes ;
	
	/**
     * Main constructor
     *
     * @param   string		$text     The content to display
     */
	function __construct($text) {

    }
	
    /**
     * Build an svg text element.
     *
     * @access  public
     * @param   boolean		$isRoot     Unsused, kept to match parent
     * @return  string
     */
     public function build ( boolean $isRoot=NUll ) {

	 }
    
    /**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     * @return  string
     */
    public function add ( \Hoathis\Svg\Graphic $element ) {
		 
	}
	
}

}
