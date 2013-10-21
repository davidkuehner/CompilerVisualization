<?php

namespace Hoathis\GraphicTools\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../../GraphicTools/Rect.php';

use \mageekguy\atoum;
use \Hoathis\GraphicTools as gt;

class Rect extends atoum\test
{
    public function testBuild() {
		$assert = '<rect />';
		
		$group = new gt\Rect();
        $this->string( $group->build() )->isEqualTo( $assert );     
        
        $assert = '<rect width="300" height="100" style="fill:rgb(0,0,255);" />';
        $group->setAttributes( array('width'=>'300', 'height'=>'100', 'style'=>'fill:rgb(0,0,255);' ) );
        $this->string( $group->build() )->isEqualTo( $assert );  
        
    }
    
 }
