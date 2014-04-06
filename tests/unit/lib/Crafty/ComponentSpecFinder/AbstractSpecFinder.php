<?php


namespace Knt\Crafty\ComponentSpecFinder\tests\unit;

require_once('../../lib/Crafty/Crafty.php');

use 
    atoum
;


abstract class AbstractSpecFinder extends atoum {

    protected $_finder;
    protected $_factory;
    
    abstract public function getFactory();
    
    abstract public function getFinder();
    
    public function testBasicSpecFinding() {
                
        $spec = $this
            ->getFinder()
            ->findSpecFor('empty', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('EmptyClass')
            
        ;
        
    }

    public function testSharedInstanceSpecFinding() {
                
        $spec = $this
            ->getFinder()
            ->findSpecFor('sharedComponent', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('stdClass')
            
            ->boolean($spec->isShared())
                ->isTrue()
            
        ;
        
    }
    
    public function testSetterBasedInjectionSpecFinding() {
        
        $spec = $this
            ->getFinder()
            ->findSpecFor('setterBased', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('SetterInjectionClass')
            
            ->array($prop = $spec->getProperty('prop1'))
                ->object($prop[0])
                    ->isInstanceOf('\Knt\Crafty\ComponentReference')
                    ->string($prop[0]->getComponentName())
                        ->isEqualTo('empty')
                ->object($prop[1])
                    ->isInstanceOf('\Knt\Crafty\ComponentReference')
                    ->string($prop[1]->getComponentName())
                        ->isEqualTo('sharedComponent')
            ->string($spec->getProperty('prop2'))
                ->isEqualTo('test')
            
        ;
       
    }
    
    
    public function testConstructorBasedInjectionSpecFinding() {
  
        $spec = $this
            ->getFinder()
            ->findSpecFor('constructorBased', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('ConstructorInjectionClass')
            
            ->array($constructorArgs = $spec->getConstructorArgs())
                ->variable($constructorArgs[0])
                    ->isEqualTo('foo')
                ->array($constructorArgs[1])
                    ->variable($constructorArgs[1][0])
                        ->isEqualTo('bar')
                    ->variable($constructorArgs[1][1])
                        ->isEqualTo('test')
            
        ;
    
    }
    
    public function testDefaultTypeIsString() {
        
        $spec = $this
            ->getFinder()
            ->findSpecFor('constructorBased', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('ConstructorInjectionClass')
            
            ->array($constructorArgs = $spec->getConstructorArgs())
                ->string($constructorArgs[0])
                ->array($constructorArgs[1])
                    ->string($constructorArgs[1][0])
                    ->string($constructorArgs[1][1])
            
        ;
        
    }
  
    public function testIntegerType() {
        
        $spec = $this
            ->getFinder()
            ->findSpecFor('constructorBased', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('ConstructorInjectionClass')
            
            ->array($constructorArgs = $spec->getConstructorArgs())
                ->array($constructorArgs[1])
                    ->integer($constructorArgs[1][2])
                    ->integer($constructorArgs[1][3])
            
        ;
        
    }
  
  
    public function testFloatType() {
        
        $spec = $this
            ->getFinder()
            ->findSpecFor('constructorBased', $this->getFactory());
        
        $this
            
            ->object($spec)
                ->isInstanceOf('\Knt\Crafty\ComponentSpec')
            
            ->string($spec->getClassName())
                ->isEqualTo('ConstructorInjectionClass')
            
            ->array($constructorArgs = $spec->getConstructorArgs())
                ->array($constructorArgs[1])
                    ->float($constructorArgs[1][4])
            
        ;
        
    }
    
    public function testNullIsReturnedOnFailure() {
        
        $spec = $this
            ->getFinder()
            ->findSpecFor('nothing', $this->getFactory());
        
        
        $this
            ->variable($spec)
                ->isNull()
        ;
        
    }
  
}
