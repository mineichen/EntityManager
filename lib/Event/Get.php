<?php

namespace mineichen\entityManager\event;

use mineichen\entityManager\entity\Observable;

class Get implements Event
{
    private $caller;
    private $key;
    private $value;

    public function __construct(Observable $caller, $key, $value)
    {
        $this->caller = $caller;
        $this->key = $key;
        $this->value = $value;
    }

    public function getType()
    {
        return self::GET;
    }

    public function getCaller()
    {
        return $this->caller;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}