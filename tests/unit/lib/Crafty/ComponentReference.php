<?php

namespace tests\unit;

require_once('../../lib/Crafty/ComponentReference.php');

use atoum;

class Crafty_ComponentReference extends atoum {

    public function testGetComponentName() {
        
        $this
            ->object($ref = new \Crafty_ComponentReference('test'))
            ->string($ref->getComponentName())
                ->isEqualTo('test')
            
            ->object($ref = new \Crafty_ComponentReference('other'))
            ->string($ref->getComponentName())
                ->isEqualTo('other')
            
        ;
                
    }
       
}
