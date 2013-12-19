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
	 const FONT_SIZE_UNIT = 'px';
	 const FONT_SIZE_COMMENT = 8;
	 const PATH_COLOR = 'gray';
	 const TOKEN_COLOR = 'lightgray';
	 const COND_COLOR = 'Moccasin';
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
				$token = $this->createLiteralToken( $value, SvgCreator::TOKEN_COLOR );
				break;
			case "index":
				$token = $this->createLiteralToken( 'if ' . $token . ' : ' . $value , SvgCreator::COND_COLOR );
				break;
			case "zero_or_one":
			case "zero_or_one_lazy":
			case "zero_or_one_possessive":
				$token = new NullNode();
				$token = $this->createDefaultToken( $display );
				break;
			case "exactly_n":
			case "exactly_n_lazy":
			case "exactly_n_possessive":
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$token = $this->createDefaultToken( $display );
				break;
			case "n_to_m":
			case "n_to_m_lazy":
			case "n_to_m_possessive":
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$display = str_replace('m', $match[0][1], $display);
				$token = $this->createDefaultToken( $display );
				break;
			case "n_or_more":
			case "n_or_more_lazy":
			case "n_or_more_possessive":
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
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
		$class->setHeight( -self::BIG_MARGIN );
		return $class;
	}
	
	/**
	 * Creates and returns Buildable Negative element. 
	 */
	public function createNegativeClass() {
		$negClass = $this->createClass();
		$negClass->addComment( 'not: ' );
		return $negClass;
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
		$class = new Svg();
		$class->setVerticalLayout();
		$class->addPaths();
		$class->setMargin( self::BIG_MARGIN );
		$class->setHeight( -self::BIG_MARGIN );
		return $class;
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
	
	private function createLiteralToken( $value, $fill_color ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setAttributes( array( 'text-anchor'=>'middle' ) );
		
		$rect = new \Hoathis\GraphicTools\Rect();
		$rect->setHeight( $textCell->getHeight() + self::MARGIN*2 );
		$rect->setWidth( $textCell->getWidth() + self::MARGIN*2 );
		$rect->setAttributes( array( 'fill'=> $fill_color ) );
		$rect->setAttributes( array( 'rx'=>SvgCreator::TOKEN_ROUND_CORNER, 'ry'=>SvgCreator::TOKEN_ROUND_CORNER ) );
		
		$literal = new \Hoathis\GraphicTools\Svg();
		$literal->setHeight( $rect->getHeight() );
		$literal->setWidth( $rect->getWidth() );
		
		$literal->addChild( $rect );
		$literal->addChild( $textCell );
		
		return $literal;
	}
	
	public function createDefaultToken( $value ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setAttributes( array( 'text-anchor'=>'middle', 'font-size' => ( Self::FONT_SIZE_LEGEND ) ) );
		$textCell->setWidth( 0 ); // little hack to avoid quantification to take the width of the label
		return $textCell;
	}
	
	public function createLookahead() {
		$lookahead = $this->createClass();
		$lookahead->addComment( 'followed by: ' );
		return $lookahead;
	}
	public function createNegativeLookahead(){
		$nlookahead = $this->createClass();
		$nlookahead->addComment( 'not followed by: ' );
		return $nlookahead;
	}
	public function createLookbehind(){
		$lookbehind = $this->createClass();
		$lookbehind->addComment( 'precede by: ' );
		return $lookbehind;
	}
	public function createNegativeLookbehind(){
		$nlookbehind = $this->createClass();
		$nlookbehind->addComment( 'not precede by: ' );
		return $nlookbehind;
	}
	public function createAbsoluteCondition(){
		$condition = new Svg();
		$condition->setHorizontalLayout();
		$condition->setMargin( 0 );
		$condition->addCondition();
		return $condition;
	}
	
	
}
}
