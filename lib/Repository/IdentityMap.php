<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\action\Action;
use mineichen\entityManager\entity\Managable;

class IdentityMap
{
    private $actions = [];
    private $subjects = [];
    private $actionWithId = [];

    public function attach(Action $action)
    {
        if ($this->isIdRegistered($action->getSubject())) {
            $this->actionWithId[$action->getSubject()->getId()] = $action;
        }

        $i = array_search($action->getSubject(), $this->subjects);

        if ($i === false) {
            $this->actions[] = $action;
            $this->subjects[] = $action->getSubject();
            return false;
        }

        $this->actions[$i] = $action;
        return true;
    }

    public function fetchSubjectForId($id)
    {
        if(array_key_exists($id, $this->actionWithId)) {
            return $this->actionWithId[$id];
        }

        foreach($this->subjects as $subject) {
            if($subject->hasId() && $subject->getId() === $id) {
                return $subject;
            }
        }
        return false;
    }

    public function detach(Managable $subject)
    {
        if($this->isIdRegistered($subject)) {
            unset($this->actionWithId[$subject->getId()]);
            return;
        }
        $i = $this->getIndex($subject);
        unset($this->actions[$i]);
        unset($this->subjects[$i]);
    }

    public function getActionFor(Managable $subject)
    {
        if($this->isIdRegistered($subject)) {
            return $this->actionWithId[$subject->getId()];
        }
        return $this->actions[$this->getIndex($subject)];
    }

    public function hasActionFor(Managable $subject)
    {
        return $this->isIdRegistered($subject) ||  in_array($subject, $this->subjects, true);
    }

    public function getActions()
    {
        return array_merge($this->actions, $this->actionWithId);
    }

    private function getIndex(Managable $subject)
    {
        $i = array_search($subject, $this->subjects);
        if ($i === false) {
            throw new Exception('No Action found for type "%s" and id "%s"', $subject->getType() ,$subject->getId());
        }
        return $i;
    }

    private function isIdRegistered(Managable $subject)
    {
        return $subject->hasId() && array_key_exists($subject->getId(), $this->actionWithId);
    }
}