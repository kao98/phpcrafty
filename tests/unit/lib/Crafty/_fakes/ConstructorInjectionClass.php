<?php

class ConstructorInjectionClass {

    private $_prop1;
    private $_prop2;

    public function __construct($prop1, $prop2) {
        $this->_prop1 = $prop1;
        $this->_prop2 = $prop2;
    }

    public function getProp1() {
        return $this->_prop1;
    }

    public function getProp2() {
        return $this->_prop2;
    }

}
