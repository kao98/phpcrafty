<?php

namespace Knt\Crafty\tests\unit;

require_once(__DIR__ . '/AbstractSpecFinder.php');
require_once('../../lib/Crafty/ComponentSpecFinder/XmlSpecFinder.php');

use 
    Knt\Crafty
;

class ComponentSpecFinder_XmlSpecFinder extends ComponentSpecFinder_AbstractSpecFinder {

    public function getFactory() {
        return new Crafty\ComponentFactory();
    }
    
    public function getFinder() {
        
        $xml = 
            '<?xml version="1.0" ?>' .
            '<components>' .
            '  <component>' .
            '    <name>empty</name>' .
            '    <className>EmptyClass</className>' .
            '  </component>' .
            '  <component>' .
            '    <name>sharedComponent</name>' .
            '    <className>stdClass</className>' .
            '    <shared>true</shared>' .
            '  </component>' .
            '  <component>' .
            '    <name>setterBased</name>' .
            '    <className>SetterInjectionClass</className>' .
            '    <properties>' .
            '      <property>' .
            '        <key>prop1</key>' .
            '        <collection>' .
            '          <componentRef>empty</componentRef>' .
            '          <componentRef>sharedComponent</componentRef>' .
            '        </collection>' .
            '      </property>' .
            '      <property>' .
            '        <key>prop2</key>' .
            '        <value>test</value>' .
            '      </property>' .
            '    </properties>' .
            '  </component>' .
            '  <component>' .
            '    <name>constructorBased</name>' .
            '    <className>ConstructorInjectionClass</className>' .
            '    <constructor>' .
            '      <arg>' .
            '        <value>foo</value>' .
            '      </arg>' .
            '      <arg>' .
            '        <collection>' .
            '          <value>bar</value>' .
            '          <value>test</value>' .
            '          <value type="integer">100</value>' .
            '          <value type="int">2</value>' .
            '          <value type="float">0.5</value>' .
            '        </collection>' .
            '      </arg>' .
            '    </constructor>' .
            '  </component>' .
            '</components>';

        return new Crafty\ComponentSpecFinder_XmlSpecFinder($xml);
    }

}
