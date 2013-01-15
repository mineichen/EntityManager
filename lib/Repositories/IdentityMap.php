<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\ActionPriorityGenerator;

class IdentityMap
{
    private $map;
    private $generator;

    public function __construct(RepositoryRecordGenerator $generator)
    {
        $this->map = new \SplObjectStorage();
        $this->generator = $generator;
    }

    public function attach(Managable $subject, $actionType)
    {
        $record = $this->generator->create($subject, $actionType, $this);
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

    public function getRecordFor(Managable $subject)
    {
        return $this->map->offsetGet($subject);
    }

    public function hasRecordFor(Managable $subject)
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