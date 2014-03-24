<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\action\Action;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\action\Factory;
use mineichen\entityManager\entity\Managable;

class IdentityMap implements \IteratorAggregate
{
    private $map;

    public function __construct()
    {
        $this->map = new \SplObjectStorage();
    }

    public function attach(Action $action)
    {
        $this->map->attach($action->getSubject(), $action);
    }

    public function detach(Managable $subject)
    {
        $this->map->detach($subject);
    }

    public function getActionFor(Managable $subject)
    {
        return $this->map->offsetGet($subject);
    }

    public function hasActionFor(Managable $subject)
    {
        return $this->map->offsetExists($subject);
    }

    public function getIterator()
    {
        return $this->map;
    }
}