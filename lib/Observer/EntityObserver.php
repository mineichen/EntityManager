<?php

namespace mineichen\entityManager\action\plugin\observer;

use mineichen\entityManager\event;

class EntityObserver implements \mineichen\entityManager\observer\Observer
{
    private $changes = array();

    public function __construct($subject)
    {
        $this->subject = $subject;
        $this->subject->on(event\Event::SET, array($this, 'registerChange'));
    }

    public function registerChange(event\Set $event)
    {
        if ($event->hasValueChanged()) {
            $this->changes[$event->getKey()] = $event->getNewValue();
        }
    }

    public function getDiffs($reset = true)
    {
        $changes = $this->changes;
        if($reset) {
            $this->changes = [];
        }
        return $changes;
    }

    public function hasDiffs()
    {
        return (bool)$this->changes;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}