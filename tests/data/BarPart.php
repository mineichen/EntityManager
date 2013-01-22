<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entity\EntityPart;


class BarPart implements EntityPart
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