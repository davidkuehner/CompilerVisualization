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
		
		$group = new Svg\Group();
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $assert = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1"></svg>';
        $this->string( $group->build(true) )->isEqualTo( $assert );
        
        
    }
    
    public function testAdd() {
		$assert = '<g><g></g></g>';
        
        $child = new Svg\Group();
        $group = new Svg\Group();
        $group->add( $child );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<g><text y="1em">' . $str . '</text></g>';
		
		$text = new Svg\Text( $str );
        $group = new Svg\Group();
        $group->add( $text );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str2 = "I’ve got a very bad feeling about this.";
        $assert = '<g><g><text y="1em">' . $str . '</text></g><text y="1em">' . $str2 . '</text></g>';
        
        $group = new Svg\Group();
        $childGroup = new Svg\Group();
        $childGroup->add( $text );
        $group->add( $childGroup );
        $text2 = new Svg\Text( $str2 );
        $group->add( $text2 );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $assert = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1"><g><text y="1em">' . $str . '</text></g></svg>';
        
        $group = new Svg\Group();
        $childGroup = new Svg\Group();
        $childGroup->add( $text );
        $this->string( $group->build(true) )->isEqualTo( $assert );
	}
}
