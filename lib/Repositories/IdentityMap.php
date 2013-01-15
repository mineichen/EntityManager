<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\ActionPriorityGenerator;

class IdentityMap
{
    private $map;

    public function __construct()
    {
        $this->map = new \SplObjectStorage();
    }

    public function attach(RepositoryRecord $record)
    {
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