<?php

namespace mineichen\entityManager\event;

trait ObservableTrait
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

    public function off($eventType, Callable $removeCallback)
    {
        $this->callbacks[$eventType] = array_filter(
            $this->getEvents($eventType),
            function($callback) use ($removeCallback) {
                return $callback !== $removeCallback;
            }
        );
    }

    private function getEvents($eventType)
    {
        if (array_key_exists($eventType, $this->callbacks)) {
            return $this->callbacks[$eventType];
        }

        return array();
    }
}