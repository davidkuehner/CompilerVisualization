<?php

namespace vendor\project\tests\units;

require_once '/usr/local/lib/Hoathis/Tests/mageekguy.atoum.phar';
//require_once path.'/mageekguy.atoum.phar';

include '/usr/local/lib/Hoathis/Tests/mocks/helloWorld.php';

use \mageekguy\atoum;
use \vendor\project;

class helloWorld extends atoum\test
{
    public function testSay()
    {
        $helloWorld = new project\helloWorld();

        $this->string($helloWorld->say())->isEqualTo('Hello World!');
    }
}
