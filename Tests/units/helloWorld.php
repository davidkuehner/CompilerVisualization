<?php

namespace vendor\project\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../mocks/helloWorld.php';

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
