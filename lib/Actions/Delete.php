<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\observer\Observer;

class Delete implements Action
{
    private $saver;
    private $observer;
    private $identityMap;

    public function __construct(Saver $saver, Observer $observer, IdentityMap $identityMap) {
        $this->saver = $saver;
        $this->observer = $observer;
        $this->identityMap = $identityMap;
    }

    public function performAction()
    {
        $this->saver->delete($this->observer);
        $this->identityMap->detach($this->getSubject());
    }

    public function getSubject()
    {
        return $this->observer->getSubject();
    }

    public function hasNeedForAction()
    {
        return true;
    }
}