<?php

namespace mineichen\entityManager\event;

class Dispatcher
{
    private $callbacks = [];

    public function trigger(Event $event)
    {
        if (array_key_exists($event->getType(), $this->callbacks)) {
            array_walk($this->callbacks[$event->getType()], function($callback) use ($event) {
                call_user_func($callback, $event);
            });
        }
    }

    public function on($eventType, Callable $callable)
    {
        $this->callbacks[$eventType][] = $callable;
    }
}