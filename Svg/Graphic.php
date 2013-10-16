<?php

namespace Hoathis\Svg {

/**
 * Class \Hoathis\Svg\Graphic.
 *
 * Abstract class that represents both primitives and 
 * containers elements for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Graphic  {
	
	const XML_STANDALONE_VERSION = '<?xml version="1.0" standalone="no"?>';
	const XML_STANDALONE_DTD = '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
	const XML_XMLNS = 'xmlns="http://www.w3.org/2000/svg"';

    /**
     * Build an svg element.
     *
     * @access  public
     * @param   boolean		$isRoot     Is this element the svg root ?
     * @return  string
     */
    abstract public function build ( boolean $isRoot=Null );
    
    /**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     * @return  string
     */
    abstract public function add ( \Hoathis\Svg\Graphic $element );
	
}

}
