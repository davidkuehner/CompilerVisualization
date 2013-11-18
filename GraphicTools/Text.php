<?php

namespace Hoathis\GraphicTools {

from('Hoathis')
->import('GraphicTools.Inode')
->import('GraphicTools.TextNode')
->import('GraphicTools.SvgCreator');

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
     
    /*
     * Ratio between font size and y alignment
     */
     const RATIO = 7;
     
	function __construct($text) {
		parent::__construct();		

        /* y height and width are hardcoded because they are 
         * nessesary to display the text. It can be overrided.
         */ 
        $this->attributes = array( 	'y' => SvgCreator::FONT_SIZE +  SvgCreator::FONT_SIZE/Self::RATIO . SvgCreator::UNITS, 
									'height' => SvgCreator::FONT_SIZE . SvgCreator::UNITS,
									'font-family' => SvgCreator::FONT_FAMILY,
									'font-size' => SvgCreator::FONT_SIZE );
		// text width calculation
		$this->widthSetting( $text );
		
        $this->elements = array();
        $textNode = new \Hoathis\GraphicTools\TextNode( $text );
        $this->addChild( $textNode );
    }
    
    /**
     * Get the textNode text value
     * 
     * @return string The value 
     */
     public function getText() {
		return $this->elements[0]->getText();
	 }
	 
	 /**
     * Set the textNode text value
     * 
     * @param string The value 
     */
     public function setText( $text ) {
		 $this->widthSetting( $text );
		 $this->elements[0]->setText( $text );
	 }
	 
	 private function widthSetting( $text ) {
		list($left,$down, $right,,,$up) = imagettfbbox( SvgCreator::FONT_SIZE, 0, __Dir__ . SvgCreator::FONT_PATH , $text);
		$fontWidth = $right - $left;
		$this->attributes[ 'width' ] = $fontWidth . SvgCreator::UNITS;
		$this->attributes[ 'x' ] = ( $fontWidth / 2 + SvgCreator::MARGIN ) . SvgCreator::UNITS;
	 }
	 
	 public function setWidthRecursively( $value, $unit ) {
		 $this->setWidth( $value, $unit );
		 $this->attributes[ 'x' ] = ( $value/2 ) .SvgCreator::UNITS;
	 }
	
}

}
