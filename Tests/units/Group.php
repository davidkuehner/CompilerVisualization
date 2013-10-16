<?php

namespace Hoathis\Svg\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../../Svg/Group.php';
require_once __DIR__.'/../../Svg/Text.php';
require_once __DIR__.'/../../Svg/Graphic.php';

use \mageekguy\atoum;
use \Hoathis\Svg;

class Group extends atoum\test
{
    public function testBuild() {
		$assert = '<g></g>';
		
		$group = new Svg\Group();
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $assert = '<svg ' . \Hoathis\Svg\Group::XML_XMLNS . ' ' . \Hoathis\Svg\Group::XML_VERSION . '></svg>';
        $this->string( $group->build(true) )->isEqualTo( $assert );
        
        
    }
    
    public function testAddElement() {
		$assert = '<g><g></g></g>';
        
        $child = new Svg\Group();
        $group = new Svg\Group();
        $group->addElement( $child );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<g><text y="1em">' . $str . '</text></g>';
		
		$text = new Svg\Text( $str );
        $group = new Svg\Group();
        $group->addElement( $text );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str2 = "I’ve got a very bad feeling about this.";
        $assert = '<g><g><text y="1em">' . $str . '</text></g><text y="1em">' . $str2 . '</text></g>';
        
        $group = new Svg\Group();
        $childGroup = new Svg\Group();
        $childGroup->addElement( $text );
        $group->addElement( $childGroup );
        $text2 = new Svg\Text( $str2 );
        $group->addElement( $text2 );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $assert = '<svg ' . \Hoathis\Svg\Group::XML_XMLNS . ' ' . \Hoathis\Svg\Group::XML_VERSION . '><g><text y="1em">' . $str . '</text></g></svg>';
        
        $group = new Svg\Group();
        $childGroup = new Svg\Group();
        $childGroup->addElement( $text );
        $group->addElement( $childGroup );
        $this->string( $group->build(true) )->isEqualTo( $assert );
	}
}
