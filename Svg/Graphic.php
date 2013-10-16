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
