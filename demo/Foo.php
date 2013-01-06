<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\asArray\Observable;

class Foo implements Observable
{
    use entityObserver\IdTrait;
    
    private $baz;
    private $bat;
    private $optional;
    
    public function __construct($baz, $bat)
    {
        $this->baz = $baz;
        $this->bat = $bat;
    }
    
    public function getType() {
        return 'Foo';
    }
    
    public function asArray() {
        return array(
            'bat' => $this->bat, 
            'baz' => $this->baz,
            'optional' => $this->optional
        );
    }   
    
    public function setBaz($baz)
    {
        $this->baz = $baz;
    }
    
    public function setOptional($value)
    {
        $this->optional = $value;
    }
}
