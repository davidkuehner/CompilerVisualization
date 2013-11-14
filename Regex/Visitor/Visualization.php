<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2013, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace {

from('Hoa')

/**
 * \Hoa\Visitor\Visit
 */
-> import('Visitor.Visit');

from('Hoathis')
/**
 * \Hoathis\GraphicTools\*
 */
->import('GraphicTools.*');

}

namespace Hoathis\Regex\Visitor {

/**
 * Class \Hoathis\Regex\Visitor\Visualization.
 *
 * Compile AST of a PCRE to SVG.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class Visualization implements \Hoa\Visitor\Visit {
	
	 /**
     * Graphic
     *
     * @var \Hoathis\GraphicTools\Graphic
     */
    //protected $_Graphic;

    /**
     * Visit an element.
     *
     * @access  public
     * @param   \Hoa\Visitor\Element  $element    Element to visit.
     * @param   mixed                 &$handle    Handle (reference).
     * @param   mixed                 $eldnah     Handle (not reference).
     * @return  mixed
     */
    public function visit ( \Hoa\Visitor\Element $element,
                            &$handle = null, $eldnah = null ) {							
		$Graphic = null;
        $id = str_replace( '#', '' , $element->getId() );
        $GraphicCreator = \Hoathis\GraphicTools\SvgCreator::getInstance();
        
        		
        switch($id) {
            case 'expression':
                $Graphic = $GraphicCreator->createExpression();
                break;
            case 'quantification':
                $Graphic = $GraphicCreator->createQuantification();
                break;
            case 'concatenation':
				$Graphic = $GraphicCreator->createConcatenation();
				break;
            case 'class':
				$Graphic = $GraphicCreator->createClass();
				break;
			case 'token':
				$value = $element->getValue();
				$Graphic = $GraphicCreator->createToken($value['token'], $value['value']);
				break;
        }
        $Graphic->setAttribute( "class", $id );
        
        
        
        
        foreach($element->getChildren() as $child) {
			$visitorElement = $child->accept($this, $handle, $eldnah);
            $Graphic->addChild($visitorElement);
		}
		        
        if ($id == 'expression') {
			echo $Graphic->build();
		} else {
			return $Graphic;
		}
    }
}

}
