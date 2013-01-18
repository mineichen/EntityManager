<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\asArray\Observable;
use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\proxy\Complementable;

class Foo implements Observable, Managable, Complementable
{
    use entityObserver\EntityTrait;
    use proxy\LazyLoad;

    private $valueToComplement;

    public function __construct($baz, $bat)
    {
        $this->setBaz($baz);
        $this->setBat($bat);
    }

    public function getType() {
        return 'Foo';
    }

    public function asArray() {
        return array(
            'bat' => $this->get('bat'),
            'baz' => $this->get('baz'),
            'optional' => $this->hasOptional() ? $this->getOptional() : null,
            'valueToComplement' => $this->hasValueToComplement() ? $this->get('valueToComplement') : null
        );
    }

    public function setBaz($baz)
    {
        $this->set('baz', $baz);
    }

    public function setBat($bat)
    {
        $this->set('bat', $bat);
    }

    public function getBaz()
    {
        return $this->has('baz') ? $this->get('baz') : null;
    }

    public function getBat()
    {
        return $this->has('bat') ? $this->get('bat') : null;
    }

    public function setValueToComplement($value)
    {
        $this->set('valueToComplement', $value);
    }

    public function getValueToComplement()
    {
        return $this->lazyLoad($this->hasValueToComplement() ? $this->get('valueToComplement') : null);
    }

    protected function hasValueToComplement()
    {
        return $this->has('valueToComplement');
    }

    public function setOptional($value)
    {
        $this->set('optional', $value);
    }

    public function hasOptional()
    {
        return $this->has('optional');
    }

    public function getOptional()
    {
        return $this->get('optional');
    }
}