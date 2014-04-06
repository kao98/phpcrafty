<?php

namespace Knt\Crafty\tests\unit;

require_once('../../lib/Crafty/Crafty.php');

require_once(__DIR__ . '/_fakes/EmptyClass.php');
require_once(__DIR__ . '/_fakes/ConstructorInjectionClass.php');
require_once(__DIR__ . '/_fakes/SetterInjectionClass.php');

use 
    atoum,
    Knt\Crafty
;

class ComponentFactory extends atoum {
    
    private $_factory;
    
    public function beforeTestMethod($method) {
        $this->_factory = new Crafty\ComponentFactory();
    }
    
    public function testNewComponentSpec() {

        $this
            ->object($this->_factory->newComponentSpec())
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
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
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
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
                ->isInstanceOf('\Knt\Crafty\ComponentReference')
            
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
        
        $locator1 = new \mock\Knt\Crafty\ClassLocator\ClassLocatorInterface;
        $locator2 = new \mock\Knt\Crafty\ClassLocator\ClassLocatorInterface;
        
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
                ->isInstanceOf('\Knt\Crafty\ComponentReflector')
            
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
    
    public function testConstructorBasedInjectionByValue() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('ConstructorInjectionClass');
        $spec->setConstructorArgs(array('foo', 'bar'));
        
        $this->_factory->setComponentSpec('constructorClass', $spec);
        
        $this
            ->object($o = $this->_factory->create('constructorClass'))
                ->isInstanceOf('ConstructorInjectionClass')
                
            ->variable($o->getProp1())
                ->isEqualTo('foo')
                
            ->variable($o->getProp2())
                ->isEqualTo('bar')
        ;
    }
      
    public function testSetterBasedInjectionByValue() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('SetterInjectionClass');
        $spec->setProperty('prop1', 'foo');
        $spec->setProperty('prop2', 'bar');
        
        $this->_factory->setComponentSpec('setterClass', $spec);
        
        $this
            ->object($o = $this->_factory->create('setterClass'))
                ->isInstanceOf('SetterInjectionClass')
                
            ->variable($o->getProp1())
                ->isEqualTo('foo')
                
            ->variable($o->getProp2())
                ->isEqualTo('bar')
        ;
        
    }
    
    public function testConstructorBasedDependencyInjection() {
        
        $emptyClassSpec = $this->_factory->newComponentSpec();
        $emptyClassSpec->setClassName('EmptyClass');

        $setterClassSpec = $this->_factory->newComponentSpec();
        $setterClassSpec->setClassName('SetterInjectionClass');
        $setterClassSpec->setProperty('prop1', 'one');
        $setterClassSpec->setProperty('prop2', 'two');
        
        $diSpec = $this->_factory->newComponentSpec();
        $diSpec->setClassName('ConstructorInjectionClass');
        $diSpec->setConstructorArgs(array(
            $this->_factory->referenceFor('emptyClass'),
            $this->_factory->referenceFor('setterClass')
        ));
        
        $this->_factory->setComponentSpec('emptyClass',     $emptyClassSpec);
        $this->_factory->setComponentSpec('setterClass',    $setterClassSpec);
        $this->_factory->setComponentSpec('testClass',      $diSpec);
        
        $this
            ->object($o = $this->_factory->create('testClass'))
                ->isInstanceOf('ConstructorInjectionClass')
                
            ->object($o->getProp1())
                ->isInstanceOf('EmptyClass')
                
            ->object($prop2 = $o->getProp2())
                ->isInstanceOf('SetterInjectionClass')
                ->variable($prop2->getProp1())
                    ->isEqualTo('one')
                ->variable($prop2->getProp2())
                    ->isEqualTo('two')
        ;
        
    }
    
    public function testSetterBasedDependencyInjection() {
        
        $emptyClassSpec = $this->_factory->newComponentSpec();
        $emptyClassSpec->setClassName('EmptyClass');

        $constructorClassSpec  = $this->_factory->newComponentSpec();
        $constructorClassSpec->setClassName('ConstructorInjectionClass');
        $constructorClassSpec->setConstructorArgs(array(123, 456));
        
        $diSpec = $this->_factory->newComponentSpec();
        $diSpec->setClassName('SetterInjectionClass');
        $diSpec->setProperty('prop1', $this->_factory->referenceFor('emptyClass'));
        $diSpec->setProperty('prop2', $this->_factory->referenceFor('constructorClass'));
        
        $this->_factory->setComponentSpec('emptyClass',       $emptyClassSpec);
        $this->_factory->setComponentSpec('constructorClass', $constructorClassSpec );
        $this->_factory->setComponentSpec('testClass',        $diSpec);
        
        $this
            ->object($o = $this->_factory->create('testClass'))
                ->isInstanceOf('SetterInjectionClass')
                
            ->object($o->getProp1())
                ->isInstanceOf('EmptyClass')
                
            ->object($prop2 = $o->getProp2())
                ->isInstanceOf('ConstructorInjectionClass')
                ->variable($prop2->getProp1())
                    ->isEqualTo(123)
                ->variable($prop2->getProp2())
                    ->isEqualTo(456)
        ;
        
    }
    
    public function testRuntimeConstructorArgInjection() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('ConstructorInjectionClass');
        $spec->setConstructorArgs(array('foo', 'bar'));
        
        $this->_factory->setComponentSpec('test', $spec);
        
        $this
            ->object($o = $this->_factory->create('test', array('x', 'y')))
                ->isInstanceOf('ConstructorInjectionClass')
                
            ->variable($o->getProp1())
                ->isEqualTo('x')
                
            ->variable($o->getProp2())
                ->isEqualTo('y')
        ;
    }

    public function testSharedInstances() {
        
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('stdClass');
        $spec->setShared(true);
        
        //TODO: actuly, even if not shared pass this test.
        
        $this->_factory->setComponentSpec('test', $spec);
        
        $this
            
            ->object($this->_factory->getComponentSpec('test'))
                ->isIdenticalTo($this->_factory->getComponentSpec('test'))
            
        ;
        
    }
    
    public function testExceptionThrownForBadComponentName() {
        
        $this
                
            ->exception(
                function() {
                    $this->_factory->create('noSuchComponent');
                }
            )
                ->isInstanceOf('\Knt\Crafty\ComponentFactoryException')
                
        ;
        
    }
    
    public function testSpecFinderStrategy() {
        $spec = $this->_factory->newComponentSpec();
        $spec->setClassName('stdClass');
        
        $finder1 = new \mock\Knt\Crafty\ComponentSpecFinder\ComponentSpecFinderInterface;
        $finder2 = new \mock\Knt\Crafty\ComponentSpecFinder\ComponentSpecFinderInterface;
        $finder3 = new \mock\Knt\Crafty\ComponentSpecFinder\ComponentSpecFinderInterface;
        
        $finder1->getMockController()->findSpecFor = null;
        $finder2->getMockController()->findSpecFor = $spec;
        $finder3->getMockController()->findSpecFor = null;
        
        $this->_factory->registerSpecFinder('finder1', $finder1);
        $this->_factory->registerSpecFinder('finder2', $finder2);
        $this->_factory->registerSpecFinder('finder3', $finder3);
        
        $this
            ->variable($this->_factory->create('testComponent'))
            
            ->mock($finder1)
            
                ->call('findSpecFor')
                    ->withIdenticalArguments('testComponent', $this->_factory)
                    ->once()
            
            ->mock($finder2)
            
                ->call('findSpecFor')
                    ->withIdenticalArguments('testComponent', $this->_factory)
                    ->once()
            
            ->mock($finder3)
            
                ->call('findSpecFor')
                    ->never()
                
        ;
    }
    
}
