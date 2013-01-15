<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\actions\Factory;

class IdentityMap
{
    private $map;
    private $actionFactory;

    public function __construct(Factory $actionFactory)
    {
        $this->map = new \SplObjectStorage();
        $this->actionFactory = $actionFactory;
    }

    public function attach(Managable $subject, $actionType)
    {
        $record = $this->actionFactory->getInstanceFor($subject, $actionType, $this);
        $this->map->attach($record->getSubject(), $record);
    }

    public function detach(Managable $subject)
    {
        $this->map->detach($subject);
    }

    public function asArray()
    {
        return iterator_to_array($this->map);
    }

    public function getActionFor(Managable $subject)
    {
        return $this->map->offsetGet($subject);
    }

    public function hasActionFor(Managable $subject)
    {
        return $this->map->offsetExists($subject);
    }

    public function getSubjectsForId($id)
    {
        return array_filter(
            $this->asArray(),
            function(Managable $subject) use ($id) {
                return $subject->hasId() && $subject->getId() === $id;
            }
        );
    }

    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        $generator->appendChanges($this->map);
    }
}