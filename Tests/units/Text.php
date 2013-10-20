<?php

namespace Hoathis\GraphicTools\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
include __DIR__.'/../../GraphicTools/Text.php';

use \mageekguy\atoum;
use \Hoathis\GraphicTools as gt;

class Text extends atoum\test
{
    public function testBuild() {
		$str = "This is Red 5, I’m going in.";
		$assert = '<text y="1em">' . $str . '</text>';
		
		$text = new gt\Text($str);
        $this->string($text->build())->isEqualTo($assert);
    }
}
