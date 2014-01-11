<?php

namespace {

from('Hoathis')
/**
 * \Hoathis\Regex\Visitor\GraphicCreator
 * \Hoathis\Regex\Visitor\Buildable
 * \Hoathis\GraphicTools\SVG
 */
->import('Regex.Visitor.GraphicCreator')
->import('Regex.Visitor.Buildable')
->import('GraphicTools.Svg');
}

namespace Hoathis\GraphicTools {

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
	const FONT_PATH = '/FreeSans.ttf'; //F ont file path in the GraphicTools library
	const FONT_FAMILY = 'FreeSans';
	const FONT_SIZE = 14; 
	const FONT_SIZE_LEGEND = 10; 
	const FONT_SIZE_UNIT = 'px';
	const FONT_SIZE_COMMENT = 8;
	const PATH_COLOR = 'gray';
	const PATH_DARK_COLOR = 'rgb(69,69,69)';
	const TOKEN_COLOR = 'lightgray';
	const COND_COLOR = 'moccasin';
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
	 * @access  public
	 * @param   string  $token      Token type.
	 * @param   string  $value      Value of the token.
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createToken( $token, $value ) {

		$display = str_replace('_',' ',$token);
		
		switch ($token) {
			case 'literal':
				$token = $this->createLiteralToken( stripcslashes($value), SvgCreator::TOKEN_COLOR );
				break;
			case 'index':
				$token = $this->createLiteralToken( 'if ' . $token . ' : ' . $value , SvgCreator::COND_COLOR );
				break;
			case 'zero_or_one':
			case 'zero_or_one_lazy':
			case 'zero_or_one_possessive':
				$token = new NullNode();
				$token = $this->createDefaultToken( $display );
				break;
			case 'exactly_n':
			case 'exactly_n_lazy':
			case 'exactly_n_possessive':
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$token = $this->createDefaultToken( $display );
				break;
			case 'n_to_m':
			case 'n_to_m_lazy':
			case 'n_to_m_possessive':
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$display = str_replace('m', $match[0][1], $display);
				$token = $this->createDefaultToken( $display );
				break;
			case 'n_or_more':
			case 'n_or_more_lazy':
			case 'n_or_more_possessive':
				preg_match_all( '/[0-9]+/', $value, $match );
				$display = str_replace('n', $match[0][0], $display);
				$token = $this->createDefaultToken( $display );
				break;
			case 'anchor':
				if( $value == '^' )
					$token = $this->createLiteralToken( 'start of line', SvgCreator::TOKEN_COLOR );
				else 
					$token = $this->createLiteralToken( 'end of line', SvgCreator::TOKEN_COLOR );
				break;
			case 'character_type':
				switch($value) {
					case '\C': 
						$token = $this->createLiteralToken( ' one data unit ', SvgCreator::TOKEN_COLOR );
						break;
					case '\d': 
						$token = $this->createLiteralToken( ' decimal digit ', SvgCreator::TOKEN_COLOR );
						break;
					case '\D': 
						$token = $this->createLiteralToken( ' not a decimal digit ', SvgCreator::TOKEN_COLOR );
						break;
					case '\h': 
						$token = $this->createLiteralToken( ' horizontal white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\H': 
						$token = $this->createLiteralToken( ' not a horizontal white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\N': 
						$token = $this->createLiteralToken( ' non-newline ', SvgCreator::TOKEN_COLOR );
						break;
					case '\R': 
						$token = $this->createLiteralToken( ' newline sequence ', SvgCreator::TOKEN_COLOR );
						break;
					case '\s': 
						$token = $this->createLiteralToken( ' white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\S': 
						$token = $this->createLiteralToken( ' not a white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\v': 
						$token = $this->createLiteralToken( ' vertical white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\V': 
						$token = $this->createLiteralToken( ' not a vertical white space ', SvgCreator::TOKEN_COLOR );
						break;
					case '\w': 
						$token = $this->createLiteralToken( ' "word" ', SvgCreator::TOKEN_COLOR );
						break;
					case '\W': 
						$token = $this->createLiteralToken( ' "non-word" ', SvgCreator::TOKEN_COLOR );
						break;
					case '\X': 
						$token = $this->createLiteralToken( ' Unicode extended grapheme cluster ', SvgCreator::TOKEN_COLOR );
						break;
					default  : 
						if ( preg_match( '/p{[^}]+}/', $value ) ) {
							preg_match( '/(?<={).+(?=})/', $value, $match);
							$token = $this->createLiteralToken( ' a character with the "' . $match[0] . '" property ', SvgCreator::TOKEN_COLOR );
						}
						else if( preg_match('/P{[^}]+}/', $value ) ) {
							preg_match( '/(?<={).+(?=})/', $value, $match);
							$token = $this->createLiteralToken( ' a character without the "' . $match[0] . '" property ', SvgCreator::TOKEN_COLOR );
						}
						else {
							$token = $this->createLiteralToken( ' unknown type : ' . $value, SvgCreator::TOKEN_COLOR );
						}
				}
				break;
			default:
				$token = $this->createDefaultToken( $display );
			}
		return $token;
	}

	/**
	 * Creates and returns a Buildable Expression element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createExpression() {
		$expression = new Svg();
		$expression->setWrappingLayout();
		$expression->setMargin( self::BIG_MARGIN );
		$expression->addDots();
		return $expression;
	}

	/**
	 * Creates and returns a Buildable Class element.
	 * 
	 * @access  public
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
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createNegativeClass() {
		$negClass = $this->createClass();
		$negClass->addComment( 'not: ' );
		return $negClass;
	}

	/**
	 * Creates and returns an Buildable Quantification element.
	 * 
	 * @access  public
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
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createConcatenation() {
		$concatenation = new Svg();
		$concatenation->setHorizontalLayout();
		return $concatenation;
	}

	/**
	 * Creates and returns an Buildable Alternation element.
	 * 
	 * @access  public
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
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createRange() {
		 $range = new \Hoathis\GraphicTools\Svg();
		 $range->setHorizontalLayout();
		 return $range;
		 
	 }

	/**
	 * Creates and returns an Buildable default token element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createDefaultToken( $value ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setAttributes( array( 'text-anchor'=>'middle', 'font-size' => ( Self::FONT_SIZE_LEGEND ) ) );
		$textCell->setWidth( 0 ); // little hack to avoid quantification to take the width of the label
		return $textCell;
	}

	/**
	 * Creates and returns an Buildable lookahead element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createLookahead() {
		$lookahead = $this->createClass();
		//$lookahead->setMargin( SvgCreator::BIG_MARGIN*3 );
		$lookahead->addComment( 'followed by: ' );
		return $lookahead;
	}

	/**
	 * Creates and returns an Buildable negatice lookahead element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createNegativeLookahead(){
		$nlookahead = $this->createClass();
		$nlookahead->addComment( 'not followed by: ' );
		return $nlookahead;
	}

	/**
	 * Creates and returns an Buildable lookbehind element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createLookbehind(){
		$lookbehind = $this->createClass();
		$lookbehind->addComment( 'preceded by: ' );
		return $lookbehind;
	}

	/**
	 * Creates and returns an Buildable negative lookbehind element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createNegativeLookbehind(){
		$nlookbehind = $this->createClass();
		$nlookbehind->addComment( 'not preceded by: ' );
		return $nlookbehind;
	}

	/**
	 * Creates and returns an Buildable absolute condition element.
	 * 
	 * @access  public
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
	public function createAbsoluteCondition(){
		$condition = new Svg();
		$condition->setHorizontalLayout();
		$condition->addCondition();
		return $condition;
	}

	/**
	 * Creates and returns an Buildable literal token element.
	 * 
	 * @access  private
	 * @return Hoathis\Regex\Visitor\Buildable
	 */
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
}}
