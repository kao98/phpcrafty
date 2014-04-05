<?php

/* 
 * knt-crafty: a fork of Crafty, a php dependency injector
 * 
 * Licensed under The MIT License
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * Crafty (the original) was licensed under the 
 * GNU LESSER GENERAL PUBLIC LICENSE Version 3, 29 June 2007
 * 
 * Original project: http://sourceforge.net/projects/phpcrafty/
 * 
 * @link          http://www.kaonet-fr.net/cms
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * Functional tests use Nette Tester v1.1.
 * The Nette Tester is provided in it 1.1.0 version.
 * To run the tests, from the 'tests/functional' directory,
 * simply run the following command:
 * #>php Tester-1.1/Tester/tester Crafty
 */

require_once __DIR__ . '/../../../bootstrap.php';

use 
    Tester\Assert
;

/**
 * simplestTest is the simplest functional test we could perform
 * for Crafty: it simple contains one test method that 
 * ask to create one instance of a 'std' object
 * that is actually a 'stdClass' instance 
 * regarding the spec we give to the crafty factory.
 */
class simplestTest extends Tester\TestCase {
    
    /**
     * test-00
     * We ask the Factory to create a std that result to a stdClass instance:
     * -----------------------------------
     * Requirement:
     * 
     * Given 
     * 
     * - a spec
     *   - telling us that for a 'std' object
     *   - we instanciate a 'stdClass'
     * 
     * - a factory
     *   
     * When 
     * 
     * - we ask the factory to create an 'std' object
     * 
     * Then
     * 
     * - the result from the factory is an instance of 'stdClass'
     * 
     */
    public function test_00_Factory_Create_StdClass() {
    
    //Given
        $crafty = new \Crafty_ComponentFactory;
        $spec   = $crafty->newComponentSpec('stdClass');
        
        $crafty ->setComponentSpec  ('std', $spec);
        
    //When
        $object = $crafty->create('std');
        
    //Then
        Assert::type('Crafty_ComponentFactory', $crafty);
        Assert::type('stdClass', $object);
        
    }

}

###########################################################
#running tests
#----------------------------------------------------------

$testCase = new simplestTest;
$testCase->run();

###########################################################