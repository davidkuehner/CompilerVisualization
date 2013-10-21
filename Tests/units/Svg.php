<?php

namespace Hoathis\GraphicTools\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../../GraphicTools/Svg.php';
require_once __DIR__.'/../../GraphicTools/G.php';
require_once __DIR__.'/../../GraphicTools/Text.php';
require_once __DIR__.'/../../GraphicTools/Graphic.php';

use \mageekguy\atoum;
use \Hoathis\GraphicTools as gt;

class Svg extends atoum\test
{
    public function testBuild() {
		$assert = '<svg></svg>';
		
		$svg = new gt\Svg();
        $this->string( $svg->build() )->isEqualTo( $assert );      
    }
    
    public function testAddElement() {
		$assert = '<svg><svg></svg></svg>';
		
		$svg = new gt\Svg();
		$svg2 = new gt\svg();
		$svg->addElement($svg2);
        $this->string( $svg->build() )->isEqualTo( $assert ); 
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<svg><text y="1em">' . $str . '</text></svg>';
		
		$text = new gt\Text( $str );
        $svg = new gt\Svg();
        $svg->addElement( $text );
        $this->string( $svg->build() )->isEqualTo( $assert );
        
        $str2 = "I’ve got a very bad feeling about this.";
        $assert = '<svg><g><text y="1em">' . $str . '</text></g><text y="1em">' . $str2 . '</text></svg>';
        
        $svg = new gt\Svg();
        $childGroup = new gt\G();
        $childGroup->addElement( $text );
        $svg->addElement( $childGroup );
        $text2 = new gt\Text( $str2 );
        $svg->addElement( $text2 );
        $this->string( $svg->build() )->isEqualTo( $assert );
	}
	
	public function testAddAtributes() {
		$assert = '<svg foo="bar" han="solo"></svg>';
		
		$attrib = array("foo"=>"bar","han"=>"solo");
		$svg = new gt\Svg();
		$svg->setAttributes($attrib);
		$this->string( $svg->build() )->isEqualTo( $assert );
		
		$assert = '<svg foo="bar" han="leia" even="odds"></svg>';
		
		$attrib = array("even"=>"odds", "han"=>"leia");
		$svg->setAttributes($attrib);
		$this->string( $svg->build() )->isEqualTo( $assert );
		
		$assert = '<svg xmlns="' . gt\Svg::XML_XMLNS . '" version="' . gt\Svg::XML_VERSION . '"></svg>';
        
        $svg = new gt\svg();
		$attrib = array( "xmlns"=> gt\Svg::XML_XMLNS ,"version"=> gt\Svg::XML_VERSION );
		$svg->setAttributes($attrib);
        $this->string( $svg->build() )->isEqualTo( $assert );
	}
 }
