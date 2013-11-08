<?php

namespace Hoathis\GraphicTools {


/**
 * \Hoathis\Regex\Visitor\GraphicCreator
 * \Hoathis\Regex\Visitor\Buildable
 */
from('Hoathis')
->import('Regex.Visitor.GraphicCreator')
->import('Regex.Visitor.Buildable');

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
    public static function getInstance ( )
    {
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
     public function createToken( $token, $value )
     {
	 }
     
     /**
      * Creates and returns a Buildable Expression element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createExpression()
     {
		$expression = new \Hoathis\GraphicTools\Svg();
		return $expression;
	 }
      
     /**
      * Creates and returns a Buildable Class element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createClass()
     {
	 }
     
     /**
      * Creates and returns an Buildable Quantification element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createQuantification()
     {
	 }
     
     /**
      * Creates and returns an Buildable Concatenation element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createConcatenation()
     {
	 }
     
     /**
      * Creates and returns an Buildable Alternation element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createAlternation()
     {
	 }
	
}
}
