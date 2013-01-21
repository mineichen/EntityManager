<?php

namespace mineichen\entityManager\action\plugin\observer;

use mineichen\entityManager\event;

class EntityObserver implements \mineichen\entityManager\observer\Observer
{
    private $changes = array();

    public function __construct($subject)
    {
        $this->subject = $subject;
        $this->subject->on('set', array($this, 'registerChange'));
    }

    public function getType()
    {
        return 'observer';
    }

    public function registerChange(event\Set $event)
    {
        if ($event->hasValueChanged()) {
            $this->changes[$event->getKey()] = $event->getNewValue();
        }
    }

    public function getDiffs()
    {
        return $this->changes;
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