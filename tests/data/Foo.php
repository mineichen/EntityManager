<?php

namespace mineichen\entityManager;


class Foo implements entity\Entity
{
    use entity\EntityTrait;

    public function __construct($baz, $bat)
    {
        $this->setBaz($baz);
        $this->setBat($bat);
    }

    public function getType() {
        return 'Foo';
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
        return $this->get('valueToComplement');
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