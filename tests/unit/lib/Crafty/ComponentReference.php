<?php

namespace Knt\Crafty\tests\unit;

require_once('../../lib/Crafty/Crafty.php');

use 
    atoum,
    Knt\Crafty
;

class ComponentReference extends atoum {

    public function testGetComponentName() {
        
        $this
            ->object($ref = new Crafty\ComponentReference('test'))
            ->string($ref->getComponentName())
                ->isEqualTo('test')
            
            ->object($ref = new Crafty\ComponentReference('other'))
            ->string($ref->getComponentName())
                ->isEqualTo('other')
            
        ;
                
    }
       
}
