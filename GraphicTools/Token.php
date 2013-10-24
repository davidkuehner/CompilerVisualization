<?php

namespace Hoathis\GraphicTools {
	
require_once __DIR__.'/Inode.php';
require_once __DIR__.'/Text.php';
require_once __DIR__.'/Rect.php';

/**
 * Class \Hoathis\GraphicTools\Token.
 *
 * Concrete class that represents a token.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Token  extends \Hoathis\GraphicTools\Inode {

	/**
	 * Svg representation type
	 */
	private $representation;
	
	/**
     * Main constructor
     *
     * @param   string		$text     The content to display
     */
	function __construct($text) {
		
		// Hardcoded for the proof of concept -> will be dynamic in final implementation
		$this->representation = new \Hoathis\GraphicTools\Svg();

        $textCell = new \Hoathis\GraphicTools\Text( $text );
        $textCell->setAttributes( array( "height"=>"1em", "y"=>"1.3em",  "x"=>"0.2em" ) );
        
        $rect = new \Hoathis\GraphicTools\Rect();
        $rect->setAttributes( array( "height"=>"2em", "width"=>"2em", "fill"=>"red" ) );
        
        $this->representation->addElement( $rect );
        $this->representation->addElement( $textCell );
        
    }
    
    /**
     * Override function
     * It bypass the construction of the current element to use only the
     * representation
     *
     * @access  public
     * @return  string
     */
     public function build () {
		 		
		return $this->representation->build();
	 }
	 
	 /**
     * Override function
     * It passes the attribute to the svg representation
     * 
     * @see		$representation::setAttributes()
     * @access  public
     * @param   array	$attributes     "key"=>"value" as "width"=>"20px"
     */
	 public function setAttributes ( array $attributes ) {
		$this->representation->setAttributes( $attributes );
	}
	
}

}
