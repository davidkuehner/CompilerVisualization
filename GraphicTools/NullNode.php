<?php

namespace Hoathis\GraphicTools {
	
from('Hoathis')
/**
 * \Hoathis\GraphicTools\Graphic
 */
->import('GraphicTools.Graphic');


/**
 * Class \Hoathis\GraphicTools\NullNode.
 *
 * Concret class that represent an element without representation to build.
 * It's based on the Null Object design pattern.
 *
 * @author     David Kühner <david.kuhner@he-arc.ch>
 * @copyright  Copyright © 2007-2013 David Kühner
 * @license    New BSD License
 */

class NullNode extends \Hoathis\GraphicTools\Graphic {
	
	/**
     * Build nothing.
     *
     * @access  public
     * @return  string
     */
     public function build () {
		 return '';
	 }
	
}

}
