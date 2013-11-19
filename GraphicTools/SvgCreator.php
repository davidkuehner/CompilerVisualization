<?php

namespace Hoathis\GraphicTools {


/**
 * \Hoathis\Regex\Visitor\GraphicCreator
 * \Hoathis\Regex\Visitor\Buildable
 * \Hoathis\GraphicTools\SVG
 * \Hoathis\GraphicTools\SvgHLayout
 */
from('Hoathis')
->import('Regex.Visitor.GraphicCreator')
->import('Regex.Visitor.Buildable')
->import('GraphicTools.Svg');

/**
 * Class \Hoathis\GraphicTools\SvgCreator.
 *
 * Concrete class that represents a Graphic Creator.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class SvgCreator  implements \Hoathis\Regex\Visitor\GraphicCreator {
	
	/**
	 * Contains the instance
	 */
	private static $_instance;
	
	/*
	 * Units (em/px/...)
	 */
	const UNITS = 'px';
	
	/*
	 * Global margin between elements
	 */
	const MARGIN = 5;
	const BIG_MARGIN = 20;
	
	/*
	 * Style constants
	 */
	 const FONT_FAMILY = 'FreeSans';
	 const FONT_PATH = '/FreeSans.ttf'; //F ont file path in the GraphicTools library
	 const FONT_SIZE = 14; 
	 const FONT_SIZE_LEGEND = 10; 
	 const PATH_COLOR = 'gray';
	 const TOKEN_COLOR = 'lightgray';
	 const ARROW_COLOR = 'lightgray';
	 const TOKEN_ROUND_CORNER = 5;
	
	/**
     * Constructor is private to match the singleton.
     *
     * @access  private
     */
    private function __construct ( ) { }
	
	/**
     * Return a GraphicCreator. 
     * If it already exists, returns it. Else creates it and then return it. 
     * Purpose : match the singleton.
     *
     * @access  public
     * @return  Hoathis\Regex\Visitor\GraphicCreator
     */
    public static function getInstance ( ) {
			if( is_null( self::$_instance ) === true )
			{
				self::$_instance = new self();
				return self::$_instance;
			}
			else
			{
				return self::$_instance;
			}
	}
    
    /**
     * Creates and return a token with the given Token type and value.
     * 
     * @param   string  $token      Token type.
     * @param   string  $value      Value of the token.
     * @return Hoathis\Regex\Visitor\Buildable
     */
	public function createToken( $token, $value ) {
		 
		$display = str_replace('_',' ',$token);
		switch ($token) {
			case "literal":
				$token = $this->createLiteralToken( $value );
				break;
			case "zero_or_one":
				$token = new NullNode();
				break;
			case "n_to_m":
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$display = str_replace('m', $match[0][1], $display);
				$token = $this->createDefaultToken( $display );
				break;
			default:
				$token = $this->createDefaultToken( $display );
			}
		return $token;
	}

     
    /**
     * Creates and returns a Buildable Expression element.
     * 
     * @return Hoathis\Regex\Visitor\Buildable
     */
    public function createExpression() {
		$expression = new Svg();
		$expression->setWrappingLayout();
		return $expression;
	 }
      
	/**
     * Creates and returns a Buildable Class element.
     * 
     * @return Hoathis\Regex\Visitor\Buildable
     */
    public function createClass() {
		$class = new Svg();
		$class->setVerticalLayout();
		$class->addPaths();
		$class->setMargin( self::BIG_MARGIN );
		$class->setHeight( -self::BIG_MARGIN, self::UNITS );
		return $class;
	}
     
    /**
     * Creates and returns an Buildable Quantification element.
     * 
     * @return Hoathis\Regex\Visitor\Buildable
     */
    public function createQuantification() {
		$quantification = new Svg();
		$quantification->setWrappingLayout();
		$quantification->addLoop();
		$quantification->setMargin( self::BIG_MARGIN );
		return $quantification;
	}
     
    /**
     * Creates and returns an Buildable Concatenation element.
     * 
     * @return Hoathis\Regex\Visitor\Buildable
     */
    public function createConcatenation() {
		$concatenation = new Svg();
		$concatenation->setHorizontalLayout();
		$concatenation->setMargin( 0 );
		return $concatenation;
	}
    
    /**
     * Creates and returns an Buildable Alternation element.
     * 
     * @return Hoathis\Regex\Visitor\Buildable
     */
    public function createAlternation() {
	}
	
	/**
      * Creates and returns an Buildable Range element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createRange() {
		 $range = new \Hoathis\GraphicTools\Svg();
		 $range->setHorizontalLayout();
		 $range->setMargin( 0 );
		 return $range;
		 
	 }
	
	private function createLiteralToken( $value ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setAttributes( array( 'text-anchor'=>'middle' ) );
		
		$rect = new \Hoathis\GraphicTools\Rect();
		$rect->setHeight( $textCell->getHeight() + self::MARGIN*2, self::UNITS );
		$rect->setWidth( $textCell->getWidth() + self::MARGIN*2, self::UNITS );
		$rect->setAttributes( array( 'fill'=> SvgCreator::TOKEN_COLOR ) );
		$rect->setAttributes( array( 'rx'=>SvgCreator::TOKEN_ROUND_CORNER, 'ry'=>SvgCreator::TOKEN_ROUND_CORNER ) );
		
		$literal = new \Hoathis\GraphicTools\Svg();
		$literal->setHeight( $rect->getHeight(), self::UNITS );
		$literal->setWidth( $rect->getWidth(), self::UNITS );
		
		$literal->addChild( $rect );
		$literal->addChild( $textCell );
		
		return $literal;
	}
	
	private function createDefaultToken( $value ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setAttributes( array( 'text-anchor'=>'middle', 'font-size' => ( Self::FONT_SIZE_LEGEND ) . Self::UNITS ) );
		$textCell->setWidth( 0, Self::UNITS ); // little hack to avoid quantification to take the width of the label
		return $textCell;
	}
	
}
}
