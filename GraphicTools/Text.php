<?php

namespace {

from('Hoathis')
/**
 * \Hoathis\GraphicTools\Composite 
 * \Hoathis\GraphicTools\TextNode 
 * \Hoathis\GraphicTools\SvgCreator 
 */
->import('GraphicTools.Composite')
->import('GraphicTools.TextNode')
->import('GraphicTools.SvgCreator');
}

namespace Hoathis\GraphicTools {

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
class Text  extends \Hoathis\GraphicTools\Composite {

	/*
	 * Ratio between font size and y alignment
	 */
	const RATIO = 7;

	/**
	 * Main constructor
	 */
	function __construct($text) {
		parent::__construct();

		$this->attributes = array( 	'y' => SvgCreator::FONT_SIZE +  SvgCreator::FONT_SIZE / self::RATIO, 
									'height' => SvgCreator::FONT_SIZE,
									'font-family' => SvgCreator::FONT_FAMILY,
									'font-size' => SvgCreator::FONT_SIZE );
		// text width calculation
		$this->widthSetting( $text );
		
		$this->elements = array();
		$textNode = new \Hoathis\GraphicTools\TextNode( $text );
		$this->addChild( $textNode );
	}

	/**
	 * Gets the textNode text value.
	 * 
	 * @access public
	 * @return string The value 
	 */
	public function getText() {
		return $this->elements[0]->getText();
	}
 
	/**
	 * Sets the textNode text value.
	 * 
	 * @access public
	 * @param string The text value.
	 */
	public function setText( $text ) {
		 $this->widthSetting( $text );
		 $this->elements[0]->setText( $text );
	}

	/**
	 * Sets the width based on the text size using imagettfbbox.
	 * 
	 * @access private
	 * @param string The text value. 
	 */
	private function widthSetting( $text ) {
		list($left,$down, $right,,,$up) = imagettfbbox( SvgCreator::FONT_SIZE, 0, __Dir__ . SvgCreator::FONT_PATH , $text);
		$fontWidth = $right - $left;
		$this->attributes[ 'width' ] = $fontWidth;
		$this->attributes[ 'x' ] = ( $fontWidth / 2 + SvgCreator::MARGIN );
	}
}}
