<?php

namespace Knt\Crafty\ComponentSpecFinder;

require_once dirname(__FILE__) . '/../ComponentFactory.php';

/**
 * A ComponentSpec finding interface when no such component is registered.
 * @author Chris Corbyn
 * @package Crafty
 */
interface ComponentSpecFinderInterface
{
  
  /**
   * Try to find and create a specification for $componentName.
   * Returns NULL on failure.
   * @param string $componentName
   * @param Crafty_ComponentFactory The factory currently instantiated
   * @return Crafty_ComponentSpec
   */
  public function findSpecFor($componentName, \Knt\Crafty\ComponentFactory $factory);
  
}
