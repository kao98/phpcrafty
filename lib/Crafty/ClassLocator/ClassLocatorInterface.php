<?php

namespace Knt\Crafty\ClassLocator;

/**
 * ClassLocator interface for searching for and including class files.
 * @author Chris Corbyn
 * @package Crafty
 */
interface ClassLocatorInterface
{
  
  /**
   * Returns true if the class exists from the ClassLocator point of view.
   * @param string $className
   * @return boolean
   */
  public function classExists($className);
  
  /**
   * Include the class with the name $className.
   * @param string $className
   */
  public function includeClass($className);
  
}
