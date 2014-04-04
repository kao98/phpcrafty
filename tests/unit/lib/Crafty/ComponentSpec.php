<?php

namespace tests\unit;

require_once('../../lib/Crafty/ComponentSpec.php');

use atoum;

class Crafty_ComponentSpec extends atoum {

    public function testSetAndGetClassName() {
        
        $spec = new \Crafty_ComponentSpec();
        $spec->setClassName('EmptyClass');
        
        $this
            ->string($spec->getClassName())
                ->isEqualTo('EmptyClass')
        ;
        
    }

    public function testSetAndGetConstructorArgs() {
        
        $o      = new \stdClass();
        $spec   = new \Crafty_ComponentSpec();
        $args   = array($o, 'foo', 123);
        
        $spec->setConstructorArgs($args);
        
        $this
            ->array($spec->getConstructorArgs())
                ->isIdenticalTo($args)
        ;
        
    }
    
    public function testSetAndGetProperty() {
        
        $o      = new \stdClass();
        $arr    = array('one', 2, '3');
        $spec   = new \Crafty_ComponentSpec();
        
        $o->foo = 'bar';
        
        $spec->setProperty('propName1', 'value');
        $spec->setProperty('propName2', $o);
        $spec->setproperty('propName3', $arr);
        
        $this
            ->string($spec->getProperty('propName1'))
                ->isEqualTo('value')
            
            ->object($spec->getProperty('propName2'))
                ->isIdenticalTo($o)
            
            ->array($spec->getProperty('propName3'))
                ->isIdenticalTo($arr)
            
        ;
            
  }
    
    public function testGetProperties() {
        
        $spec   = new \Crafty_ComponentSpec();
        
        $spec->setProperty('testProp1', 'x');
        $spec->setProperty('testProp2', 'y');
        $spec->setProperty('testProp3', 'z');
        
        $this
            ->array($spec->getProperties())
                ->isEqualTo(
                    array (
                        'testProp1' => 'x',
                        'testProp2' => 'y',
                        'testProp3' => 'z'
                    )
                )
        ;
        
    }
    
    public function testSetAndGetShared() {
        
        $spec   = new \Crafty_ComponentSpec();
        
        $this
            ->boolean($spec->isShared())
                ->isFalse()
            
            ->variable($spec->setShared(true))
            ->boolean($spec->isShared())
                ->isTrue()
            
            ->variable($spec->setShared(false))
            ->boolean($spec->isShared())
                ->isFalse()
            
        ;
        
    }
       
}
