<?php

namespace Knt\Crafty;

require_once dirname(__FILE__) . '/ArraySpecFinder.php';
require_once dirname(__FILE__) . '/../../Spyc.php';

/**
 * A ComponentSpecFinder which reads from a YAML file or markup.
 * @author Chris Corbyn
 * @package Crafty
 */
class ComponentSpecFinder_YamlSpecFinder
  extends ComponentSpecFinder_ArraySpecFinder
{
  
  /**
   * Creates a new YamlSpecFinder with the given YAML file or source.
   * @param string $yaml
   */
  public function __construct($yaml)
  {
    $array = \Spyc::YAMLLoad($yaml);
    if (isset($array['components']) && is_array($array['components']))
    {
      $array = $array['components'];
    }
    else
    {
      $array = array();
    }
    parent::__construct($array);
  }
  
}
