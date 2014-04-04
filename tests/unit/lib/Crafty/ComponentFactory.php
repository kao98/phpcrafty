<?php

namespace tests\unit;

require_once('../../lib/Crafty/ComponentFactory.php');
require_once('../../lib/Crafty/ComponentReflector.php');
require_once(__DIR__ . '/_fakes/EmptyClass.php');

use atoum;

class Crafty_ComponentFactory extends atoum {
    
    private $_factory;
    
    public function beforeTestMethod($method) {
        $this->_factory = new \Crafty_ComponentFactory();
    }
    
    public function testNewComponentSpec() {

        $this
            ->object($this->_factory->newComponentSpec())
                ->isInstanceOf('Crafty_ComponentSpec')
        ;
        
    }
    
    public function testNewComponentSpecWithArgs() {
        
        $this
            ->object(
                $spec = $this->_factory->newComponentSpec(
                    'SomeClass',            //Class name
                    array(),                //Constructor args
                    array('foo' => 'bar'),  //Properties
                    true                    //Shared instance
                )
            )
                ->isInstanceOf('Crafty_ComponentSpec')
            
                ->string($spec->getClassName())
                    ->isEqualTo('SomeClass')
            
                ->array($spec->getConstructorArgs())
                    ->isEqualTo(array())
            
                ->array($spec->getProperties())
                    ->isEqualTo(array('foo' => 'bar'))
            
                ->boolean($spec->isShared())
                    ->isTrue()
            
        ;
    }
      
    public function testReferenceFor() {
        
        $this
            ->object($ref = $this->_factory->referenceFor('test'))
                ->isInstanceOf('Crafty_ComponentReference')
            
                ->string($ref->getComponentName())
                    ->isEqualTo('test')
            
        ;
        
    }
    
    public function testSetAndGetComponentSpec() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('stdClass');
        
        $this->_factory->setComponentSpec('testClass', $spec);
        
        $this
            
            ->object($this->_factory->getComponentSpec('testClass'))
                ->isIdenticalTo($spec)
            
        ;
        
    }
  
    
    public function testClassLocatorStrategy() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('stdClass');
        
        $this->_factory->setComponentSpec('testClass', $spec);
        
        $locator1 = new \mock\Crafty_ClassLocator;
        $locator2 = new \mock\Crafty_ClassLocator;
        
        $locator1->getMockController()->classExists = false;
        $locator2->getMockController()->classExists = true;
        
        $this->_factory->registerClassLocator('one', $locator1);
        $this->_factory->registerClassLocator('two', $locator2);
        
        $this
            ->variable($this->_factory->create('testClass'))
            
            ->mock($locator1)
            
                ->call('classExists')
                    ->once()
            
                ->call('includeClass')
                    ->never()
            
            ->mock($locator2)
            
                ->call('classExists')
                    ->once()
            
                ->call('includeClass')
                    ->once()
            
        ;
    }
    
    public function testClassOf() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('stdClass');
        
        $this->_factory->setComponentSpec('test', $spec);
        
        $this
            
            ->object($this->_factory->classOf('test'))
                ->isInstanceOf('Crafty_ComponentReflector')
            
        ;
        
    }
    
    public function testCreateReturnsCorrectType() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('EmptyClass');
        
        $this->_factory->setComponentSpec('testClass', $spec);
        
        $this
            ->object($this->_factory->create('testClass'))
                ->isInstanceOf('EmptyClass')
                ->isInstanceOf('EmptyInterface')
        ;
        
    }
    
    
}
