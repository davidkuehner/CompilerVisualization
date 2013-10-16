<?php

namespace Hoathis\Svg {
	
include __DIR__.'/Graphic.php';

/**
 * Class \Hoathis\Svg\Group.
 *
 * Concrete class that represents a composite element
 * for Composite pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

abstract class Group  extends \Hoathis\Svg\Graphic {
	
	/**
	 * List of elements in the group 
	 */
	private $elements = array();

    /**
     * Build an svg element.
     *
     * @access  public
     * @param   boolean		$isRoot     Is this element the svg root ?
     * @return  string
     */
     public function build ( boolean $isRoot=Null ) {

	 }
    
    /**
     * Add a child svg element.
     *
     * @access  public
     * @param   \Hoathis\Svg\Graphic	$element     The child element to add.
     * @return  string
     */
    public function add ( \Hoathis\Svg\Graphic $element ) {

	}
	
}

}
