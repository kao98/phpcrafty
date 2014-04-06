<?php

namespace Knt\Crafty\ComponentSpecFinder\tests\unit;

require_once(__DIR__ . '/AbstractSpecFinder.php');

use 
    Knt\Crafty
;

class YamlSpecFinder extends AbstractSpecFinder {

    public function getFactory() {
        return new Crafty\ComponentFactory();
    }
    
    public function getFinder() {
        
        $yaml = 
            "components:\n" .
            "  empty:\n" .
            "    className: EmptyClass\n" .
            " \n" .
            "  sharedComponent:\n" .
            "    className: stdClass\n" .
            "    shared: true\n" .
            " \n" .
            "  setterBased:\n" .
            "    className: SetterInjectionClass\n" .
            "    properties:\n" .
            "      prop1:\n" .
            "        - { componentRef: empty }\n" .
            "        - { componentRef: sharedComponent }\n" .
            "      prop2: { value: test }\n" .
            " \n" .
            "  constructorBased:\n" .
            "    className: ConstructorInjectionClass\n" .
            "    constructor:\n" .
            "      - { value: foo }\n" .
            "      -\n" .
            "        - { value: bar }\n" .
            "        - { value: test }\n" .
            "        - { value: 100 }\n" .
            "        - { value: 2 }\n" .
            "        - { value: 0.5 }\n";
        
        return new Crafty\ComponentSpecFinder\YamlSpecFinder($yaml);
    }

}
