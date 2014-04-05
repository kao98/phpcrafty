<?php

namespace Knt\Crafty\tests\unit;

require_once('../../lib/Crafty/ComponentReflector.php');
require_once(__DIR__ . '/_fakes/HybridInjectionClass.php');

use 
    atoum,
    Knt\Crafty
;

class ComponentReflector extends atoum {

    public function testReflectorIsReflectionClass() {
        
        $this
            ->object(new Crafty\ComponentReflector(
                    'HybridInjectionClass',
                    array('prop3' => 'def')
                )
            )
            
                ->isInstanceOf('ReflectionClass')
        ;
        
    }

    public function testNewsInstanceType() {
        
        $reflector = new Crafty\ComponentReflector(
            'HybridInjectionClass',
            array('prop3' => 'def')
        );
        
        $this
            ->object($reflector->newInstance(''))
                ->isInstanceOf('HybridInjectionClass')
        ;
        
    }
    
    public function testNewsInstanceArgs() {
        
        $reflector = new Crafty\ComponentReflector(
            'HybridInjectionClass',
            array('prop3' => 'def')
        );
        
        $this
            ->object($o = $reflector->newInstance('abc'))
            
            ->variable($o->getProp3())
                ->isIdenticalTo('def')
            
            ->variable($o->getProp1())
                ->isIdenticalTo('abc')
            
            ->object($o = $reflector->newInstance('xyz', 123))
            
            ->variable($o->getProp3())
                ->isIdenticalTo('def')
            
            ->variable($o->getProp1())
                ->isIdenticalTo('xyz')
            
            ->variable($o->getProp2())
                ->isIdenticalTo(123)
            
        ;
        
    }
    
}
