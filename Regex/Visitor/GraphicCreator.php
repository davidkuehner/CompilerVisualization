<?php

namespace Hoathis\Regex\Visitor {

/**
 * Interface Hoathis\Regex\Visitor\GraphicCreator
 *
 * Graphic Creator interface.
 * Implements the singleton pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

interface GraphicCreator {
	
	/**
     * Return a GraphicCreator. 
     * If it already exists, returns it. Else creates it and then return it. 
     * Purpose : match the singleton.
     *
     * @access  public
     * @return  Hoathis\Regex\Visitor\GraphicCreator
     */
    public static function getInstance ( );
    
    /**
     * Creates and return a token with the given Token type and value.
     * 
     * @param   string  $token      Token type.
     * @param   string  $value      Value of the token.
     * @return Hoathis\Regex\Visitor\Buildable
     */
     public function createToken( $token, $value );
     
     /**
      * Creates and returns a Buildable Expression element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createExpression();
     
     /**
      * Creates and returns a Buildable Class element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createClass();
     
     /**
      * Creates and returns an Buildable Quantification element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createQuantification();
     
     /**
      * Creates and returns an Buildable Concatenation element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createConcatenation();
     
     /**
      * Creates and returns an Buildable Alternation element.
      * 
      * @return Hoathis\Regex\Visitor\Buildable
      */
     public function createAlternation();
}
}
