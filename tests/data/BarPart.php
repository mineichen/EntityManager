<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\entity\Observable;


class BarPart implements Observable
{
    use entity\ObservableTrait;

    public function setValue($value)
    {
        $this->set('value', $value);
    }

    public function getValue()
    {
        return $this->get('value');
    }
}