<?php

namespace Hoathis\GraphicTools\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../../GraphicTools/G.php';
require_once __DIR__.'/../../GraphicTools/Text.php';
require_once __DIR__.'/../../GraphicTools/Graphic.php';

use \mageekguy\atoum;
use \Hoathis\GraphicTools as gt;

class G extends atoum\test
{
    public function testBuild() {
		$assert = '<g></g>';
		
		$group = new gt\G();
        $this->string( $group->build() )->isEqualTo( $assert );      
        
    }
    
    public function testAddElement() {
		$assert = '<g><g></g></g>';
        
        $child = new gt\G();
        $group = new gt\G();
        $group->addElement( $child );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<g><text y="1em">' . $str . '</text></g>';
		
		$text = new gt\Text( $str );
        $group = new gt\G();
        $group->addElement( $text );
        $this->string( $group->build() )->isEqualTo( $assert );
        
        $str2 = "I’ve got a very bad feeling about this.";
        $assert = '<g><g><text y="1em">' . $str . '</text></g><text y="1em">' . $str2 . '</text></g>';
        
        $group = new gt\G();
        $childGroup = new gt\G();
        $childGroup->addElement( $text );
        $group->addElement( $childGroup );
        $text2 = new gt\Text( $str2 );
        $group->addElement( $text2 );
        $this->string( $group->build() )->isEqualTo( $assert );
        
	}
	
	public function testAddAtributes() {
		$assert = '<g foo="bar" han="solo"></g>';
		
		$attrib = array("foo"=>"bar","han"=>"solo");
		$group = new gt\G();
		$group->setAttributes($attrib);
		
		$this->string( $group->build() )->isEqualTo( $assert );
		
		$assert = '<g foo="bar" han="leia" even="odds"></g>';
		$attrib = array("even"=>"odds", "han"=>"leia");
		$group->setAttributes($attrib);
		
		$this->string( $group->build() )->isEqualTo( $assert );
	}
}
