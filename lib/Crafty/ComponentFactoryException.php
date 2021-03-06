<?php

namespace Knt\Crafty;

/**
 * An exception thrown when an error occurs in the ComponentFactory/DI container.
 * @author Chris Corbyn
 * @package Crafty
 */
class ComponentFactoryException extends \Exception
{
  
  /**
   * Create a new ComponentFactoryException with $message.
   * @param string $message
   */
  public function __construct($message)
  {
    parent::__construct($message);
  }
  
}
