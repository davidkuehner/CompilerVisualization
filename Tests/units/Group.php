<?php

namespace Hoathis\Svg\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
include __DIR__.'/../../Svg/Group.php';
include __DIR__.'/../../Svg/Text.php';

use \mageekguy\atoum;
use \Hoathis\Svg;

class Group extends atoum\test
{
    public function testBuild() {
		$assert = '<g></g>';
		
		$Group = new Svg\Group();
        $this->string($Group->build())->isEqualTo($assert);
        
        $assert = '<g><g></g></g>';
        
        $Child = new Svg\Group();
        $Group = new Svg\Group($Child);
        $this->string($Group->build())->isEqualTo($assert);
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<g><text y="1em">' . $str . '</text></g>';
		
		$text = new Svg\Text($str);
        $Group = new Svg\Group($element);
        $this->string($Group->build())->isEqualTo($assert);
    }
}
