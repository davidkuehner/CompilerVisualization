<?php

namespace Hoathis\Svg\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
include __DIR__.'/../../Svg/Text.php';

use \mageekguy\atoum;
use \Hoathis\Svg;

class Text extends atoum\test
{
    public function testBuild() {
		$str = "This is Red 5, I’m going in.";
		$assert = '<text y="1em">' . $str . '</text>';
		
		$text = new Svg\Text($str);
        $this->string($text->build())->isEqualTo($assert);
    }
}
