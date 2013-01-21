<?php

namespace mineichen\entityManager\observer;

use mineichen\entityManager\event;
use mineichen\entityManager\proxy\NotLoaded;
use mineichen\entityManager\repository\Managable;

trait EntityTrait {
    private $id;
    private $eventManager;
    private $data = array();

    public function hasId()
    {
        return $this->id !== null;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    protected function set($key, $value)
    {
        $this->getEventManager()->trigger(
            new event\Set(
                $this,
                $key,
                $this->has($key) ? $this->get($key) : null,
                $value
            )
        );

        $this->data[$key] = $value;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \mineichen\entityManager\Exception(
                sprintf('Value for key "%s" is not set!', $key)
            );
        }
        $this->getEventManager()->trigger(
            new event\Get($this, $key, $this->data[$key])
        );

        return $this->data[$key];
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function on($eventType, Callable $callable)
    {
        $this->getEventManager()->on($eventType, $callable);
    }

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new event\Dispatcher();
        }

        return $this->eventManager;
    }

    public function complement(Managable $complete)
    {
        if (get_class($complete) !== get_class($this)) {
            throw new \mineichen\entityManager\Exception(
                sprintf(
                    'Complement needs to be an instance of "%s", "%s" given!',
                    get_class($this),
                    get_class($complete)
                )
            );
        }

        array_walk($this->data, function($value, $key) use ($complete) {
            if($value instanceof Managable) {
                $value->complement($complete->get($key));
            } elseif ($value instanceof NotLoaded) {
                $this->data[$key] = $complete->get($key);
            }
        });
    }
}