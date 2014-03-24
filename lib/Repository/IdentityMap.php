<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\action\Action;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\action\Factory;
use mineichen\entityManager\entity\Managable;

class IdentityMap implements \IteratorAggregate
{
    private $actions = [];
    private $subjects = [];

    public function attach(Action $action)
    {
        $i = array_search($action->getSubject(), $this->subjects);

        if ($i === false) {
            $this->actions[] = $action;
            $this->subjects[] = $action->getSubject();
            return false;
        }


        $this->actions[$i] = $action;
        return true;
    }

    public function detach(Managable $subject)
    {
        $i = $this->getIndex($subject);
        unset($this->actions[$i]);
        unset($this->subjects[$i]);
    }

    public function getActionFor(Managable $subject)
    {
        return $this->actions[$this->getIndex($subject)];
    }

    public function hasActionFor(Managable $subject)
    {
        return in_array($subject, $this->subjects, true);
    }

    public function getIterator()
    {
        return new \ArrayIterator(array_values($this->subjects));
    }

    private function getIndex(Managable $subject)
    {
        $i = array_search($subject, $this->subjects);
        if ($i === false) {
            throw new Exception('No Action found for type "%s" and id "%s"', $subject->getType() ,$subject->getId());
        }
        return $i;
    }
}