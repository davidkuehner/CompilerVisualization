<?php

namespace Hoathis\Svg {
	
require_once __DIR__.'/Graphic.php';

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
	
	/**
	 * Xml attributes
	 */
	private $attributes ;
	
	/**
     * Main constructor
     *
     * @param   string		$text     The content to display
     */
	function __construct($text) {
        $this->text = $text;
        /* 1em is hardcoded because it's absolutly 
         * nessesary to display the text. It can be overrided.
         */ 
        $this->attributes = [ 'y' => '1em' ];
    }
	
    /**
     * Build an svg text element.
     *
     * @access  public
     * @param   boolean		$isRoot     Unsused, kept to match parent
     * @return  string
     */
     public function build ( $isRoot=NUll ) {
		$builder = '<text'; 
		foreach ( $this->attributes as $key => $value ) {
			$builder .= ' ' . $key . '="' . $value . '"'; 
		}
		$builder .= '>';
		$builder .= $this->text;
		$builder .= '</text>';
		return $builder;
	 }
    
    /**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     * @return  string
     */
    public function addElement ( \Hoathis\Svg\Graphic $element ) {
		 
	}
	
}

}
