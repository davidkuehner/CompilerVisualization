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
->import('GraphicTools.Svg')
->import('GraphicTools.SvgHLayout');


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
	const UNITS = 'em';
	
	/*
	 * Global margin between elements
	 */
	const MARGIN = 1;
	
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
		 
		switch ($token) {
			case "literal":
				$token = $this->createLiteralToken( $value );
				break;
			case "zero_or_one":
				$token = new Svg();
				break;
			default:
				$token =  $this->createDefaultToken( $token );
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
		$class->setMargin( self::MARGIN );
		$class->setHeight( -self::MARGIN, self::UNITS );
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
		$quantification->setMargin( self::MARGIN );
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
	
	private function createLiteralToken( $value ) {
		$literal = new \Hoathis\GraphicTools\Svg();
		$literal->setHeight( self::MARGIN*2, self::UNITS );
		$literal->setWidth( self::MARGIN*2, self::UNITS );
		
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setHeight( self::MARGIN, self::UNITS );
		$textCell->setAttributes( array( "y"=>(self::MARGIN*1.3).self::UNITS,  "x"=>self::MARGIN.self::UNITS, "text-anchor"=>"middle") );
		
		$rect = new \Hoathis\GraphicTools\Rect();
		$rect->setHeight( self::MARGIN*2, self::UNITS );
		$rect->setWidth( self::MARGIN*2, self::UNITS );
		$rect->setAttributes( array( "fill"=>"red" ) );
		
		$literal->addChild( $rect );
		$literal->addChild( $textCell );
		
		return $literal;
	}
	
	private function createDefaultToken( $value ) {
		$textCell = new \Hoathis\GraphicTools\Text( $value );
		$textCell->setHeight( self::MARGIN, self::UNITS );
		$textCell->setAttributes( array( "y"=>(self::MARGIN*1.3).self::UNITS,  "x"=>self::MARGIN.self::UNITS, "text-anchor"=>"middle", "font-size" => "0.5em") );
		
		return $textCell;
	}
	
}
}
