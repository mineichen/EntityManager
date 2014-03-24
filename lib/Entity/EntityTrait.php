<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event;
use mineichen\entityManager\proxy\ComplementableTrait;


trait EntityTrait {
    private $id;
    use event\DatastoreTrait {set as storeSet; }
    use ComplementableTrait;

    public function hasId()
    {
        return $this->id !== null;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    protected function set($key, $value)
    {
        $this->setManagableEvents($this->has($key) ? $this->data[$key] : null, $value);
        return $this->storeSet($key, $value);
    }

    private function setManagableEvents($current, $newValue)
    {

        if ($newValue instanceof event\Observable && !($newValue instanceof Managable)) {
            $newValue->on(event\Event::GET, array($this, 'redirectEvent'));
            $newValue->on(event\Event::SET, array($this, 'redirectEvent'));
        }

        if ($current instanceof event\Observable && !($current instanceof Managable)) {
            $current->off(event\Event::GET, array($this, 'redirectEvent'));
            $current->off(event\Event::SET, array($this, 'redirectEvent'));
        }

    }

    public function getId()
    {
        return $this->id;
    }
}