<?php

namespace mineichen\entityManager\event;

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

    public function cloneForCaller(Observable $caller)
    {
        return new self(
            $caller,
            $this->getKey(),
            $this->getValue()
        );
    }
}