<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event;

trait ObservableTrait
{
    private $eventManager;

    public function on($eventType, Callable $callable)
    {
        $this->getEventManager()->on($eventType, $callable);
    }

    public function off($eventType, Callable $callable)
    {
        $this->getEventManager()->off($eventType, $callable);
    }

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new event\Dispatcher();
        }

        return $this->eventManager;
    }
}