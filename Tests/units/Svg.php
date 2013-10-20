<?php

namespace Hoathis\Svg\tests\units;

require_once __DIR__.'/../mageekguy.atoum.phar';
require_once __DIR__.'/../../Svg/Svg.php';
require_once __DIR__.'/../../Svg/Group.php';
require_once __DIR__.'/../../Svg/Text.php';
require_once __DIR__.'/../../Svg/Graphic.php';

use \mageekguy\atoum;
use \Hoathis\Svg as ScVeGr;

class Svg extends atoum\test
{
    public function testBuild() {
		$assert = '<svg></svg>';
		
		$svg = new ScVeGr\Svg();
        $this->string( $svg->build() )->isEqualTo( $assert );      
    }
    
    public function testAddElement() {
		$assert = '<svg><svg></svg></svg>';
		
		$svg = new ScVeGr\Svg();
		$svg2 = new ScVeGr\svg();
		$svg->addElement($svg2);
        $this->string( $svg->build() )->isEqualTo( $assert ); 
        
        $str = "I find your lack of faith disturbing.";
		$assert = '<svg><text y="1em">' . $str . '</text></svg>';
		
		$text = new ScVeGr\Text( $str );
        $svg = new ScVeGr\Svg();
        $svg->addElement( $text );
        $this->string( $svg->build() )->isEqualTo( $assert );
        
        $str2 = "I’ve got a very bad feeling about this.";
        $assert = '<svg><g><text y="1em">' . $str . '</text></g><text y="1em">' . $str2 . '</text></svg>';
        
        $svg = new ScVeGr\Svg();
        $childGroup = new ScVeGr\G();
        $childGroup->addElement( $text );
        $svg->addElement( $childGroup );
        $text2 = new ScVeGr\Text( $str2 );
        $svg->addElement( $text2 );
        $this->string( $svg->build() )->isEqualTo( $assert );
	}
	
	public function testAddAtributes() {
		$assert = '<svg foo="bar" han="solo"></svg>';
		
		$attrib = array("foo"=>"bar","han"=>"solo");
		$svg = new ScVeGr\Svg();
		$svg->setAtributes($attrib);
		$this->string( $svg->build() )->isEqualTo( $assert );
		
		$assert = '<svg foo="bar" han="leia" even="odds"></svg>';
		
		$attrib = array("even"=>"odds", "han"=>"leia");
		$svg->setAtributes($attrib);
		$this->string( $svg->build() )->isEqualTo( $assert );
		
		$assert = '<svg xmlns="' . ScVeGr\Svg::XML_XMLNS . '" version="' . ScVeGr\Svg::XML_VERSION . '"></svg>';
        
        $svg = new ScVeGr\svg();
		$attrib = array( "xmlns"=> ScVeGr\Svg::XML_XMLNS ,"version"=> ScVeGr\Svg::XML_VERSION );
		$svg->setAtributes($attrib);
        $this->string( $svg->build() )->isEqualTo( $assert );
	}
 }
