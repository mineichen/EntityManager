<?php

namespace mineichen\entityManager\event;

class Set implements Event
{
    private $caller;
    private $key;
    private $oldValue;
    private $newValue;
    private $previous;

    public function __construct(Observable $caller, $key, $oldValue, $newValue, Set $previous = null)
    {
        $this->caller = $caller;
        $this->key = $key;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
        $this->previous = $previous;
    }

    public function getType()
    {
        return self::SET;
    }

    public function getCaller()
    {
        return $this->caller;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getOldValue()
    {
        return $this->oldValue;
    }

    public function getNewValue()
    {
        return $this->newValue;
    }

    public function hasValueChanged()
    {
        return $this->getNewValue() !== $this->getOldValue();
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function cloneForCaller(Observable $caller)
    {
        return new self(
            $caller,
            $this->getKey(),
            $this->getOldValue(),
            $this->getNewValue()
        );
    }
}