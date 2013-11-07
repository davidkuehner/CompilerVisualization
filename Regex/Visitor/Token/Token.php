<?php

namespace Hoathis\Regex\Visitor\Token {


/**
 * \Hoathis\GraphicTools\Inode
 * \Hoathis\GraphicTools\Text
 * \Hoathis\GraphicTools\Rect
 */
from('Hoathis')
->import('GraphicTools.Inode')
->import('GraphicTools.Text')
->import('GraphicTools.Rect');

/**
 * Class \Hoathis\Regex\Visitor\Token.
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
	
	private $tokenType;
	
	/**
	 * Height of the token in em for now
	 */
	private $height;
	
	/**
	 * Width of the token in em for now
	 */
	private $width;
	
	/**
     * Main constructor
     *
     * @param   string		$text     The content to display
     */
	function __construct($tokenType, $text) {
		$this->representation = new \Hoathis\GraphicTools\Svg();
		$this->height = $this->width =2;
		$this->tokenType = $tokenType;

        $textCell = new \Hoathis\GraphicTools\Text( $text );
        $textCell->setAttributes( array( "height"=>"1em", "y"=>"1.3em",  "x"=>"1em", "text-anchor"=>"middle") );
        
        $rect = new \Hoathis\GraphicTools\Rect();
        $rect->setAttributes( array( "height"=> $this->height."em", "width"=> $this->width."em", "fill"=>"red" ) );
        
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
		return $this->tokenType == 'literal' ? $this->representation->build() : '' ;
		//return $this->representation->build();
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
	
	public function getHeight(){ return $this->height; }
	public function getWidth(){ return $this->width; }
	
}

}
