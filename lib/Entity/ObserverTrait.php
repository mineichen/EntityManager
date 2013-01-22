<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event;

trait ObservableTrait
{
    private $eventManager;
    private $data = array();

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

    protected function set($key, $value)
    {
        $current = $this->has($key) ? $this->data[$key] : null;
        $this->setManagableEvents($current, $value);
        $this->getEventManager()->trigger(
            new event\Set(
                $this,
                $key,
                $current,
                $value
            )
        );

        $this->data[$key] = $value;
    }

    /**
     * @todo Outsource into a Plugin
     */
    private function setManagableEvents($current, $newValue)
    {
        if ($newValue instanceof Observable) {
            if ($current instanceof $newValue) {
                $current->off(event\Event::GET, array($this, 'redirectGetEvent'));
            }
            $newValue->on(event\Event::GET, array($this, 'redirectGetEvent'));
        }
    }

    public function redirectGetEvent(event\Get $event)
    {
        $this->getEventManager()->trigger(
            new event\Get(
                $this,
                $event->getKey(),
                $event->getValue()
            )
        );
    }

    public function get($key)
    {
        $this->getEventManager()->trigger(
            new event\Get($this, $key, $this->has($key) ? $this->data[$key] : null)
        );

        return $this->has($key) ? $this->data[$key] : null;
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->data);
    }
}