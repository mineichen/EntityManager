<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event;
use mineichen\entityManager\entity\Managable;

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

    protected function getEventManager()
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
            new event\Set($this, $key, $current, $value)
        );

        $this->data[$key] = $value;
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

    private function setManagableEvents($current, $newValue)
    {
        if ($newValue instanceof Observable && !($newValue instanceof Managable)) {
            $newValue->on(event\Event::GET, array($this, 'redirectEvent'));
            $newValue->on(event\Event::SET, array($this, 'redirectEvent'));
        }

        if ($current instanceof Observable && !($current instanceof Managable)) {
            $current->off(event\Event::GET, array($this, 'redirectEvent'));
            $current->off(event\Event::SET, array($this, 'redirectEvent'));
        }
    }

    public function redirectEvent(event\Event $event)
    {
        $this->getEventManager()->trigger(
            $event->cloneForCaller($this)
        );
    }
}