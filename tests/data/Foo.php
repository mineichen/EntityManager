<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\asArray\Observable;
use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\proxy\Complementable;

class Foo implements Observable, Managable, Complementable
{
    use entityObserver\IdTrait;
    use proxy\LazyLoad;
    
    private $baz;
    private $bat;
    private $optional;
    private $valueToComplement;
    
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

    public function setBat($bat)
    {
        $this->bat = $bat;
    }

    public function getBaz()
    {
        return $this->baz;
    }

    public function getBat()
    {
        return $this->bat;
    }

    public function setValueToComplement($value)
    {
        $this->valueToComplement = $value;
    }

    public function getValueToComplement()
    {
        return $this->lazyLoad($this->valueToComplement);
    }
    
    public function setOptional($value)
    {
        $this->optional = $value;
    }
}
