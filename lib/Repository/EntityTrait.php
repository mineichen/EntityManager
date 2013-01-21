<?php

namespace mineichen\entityManager\observer;

use mineichen\entityManager\event;
use mineichen\entityManager\proxy\NotLoaded;
use mineichen\entityManager\repository\Managable;

trait EntityTrait {
    private $id;
    private $data = array();

    use \mineichen\entityManager\entity\ObservableTrait;

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
        $current = $this->has($key) ? $this->data[$key] : null;
        $this->setManagableEvents($current);
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
    private function setManagableEvents($value)
    {
        if ($value instanceof Managable) {
            if ($current instanceof $value) {
                $current->off(event\Event::GET, array($this, 'redirectGetEvent'));
            }

            $value->on(event\Event::GET, array($this, 'redirectGetEvent'));
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

    public function complement(Managable $complete)
    {
        if (!($complete instanceof self)) {
            throw new \mineichen\entityManager\Exception(
                sprintf(
                    'Complement needs to be an instance of "%s", "%s" given!',
                    get_class($this),
                    get_class($complete)
                )
            );
        }

        array_walk($this->data, function($value, $key) use ($complete) {
            if ($value instanceof Managable) {
                $value->complement($complete->get($key));
            } elseif ($value instanceof NotLoaded) {
                $this->data[$key] = $complete->get($key);
            }
        });
    }
}