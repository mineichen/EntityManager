<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\observer\Observer;

class Delete implements Action
{
    private $saver;
    private $observer;
    private $entityRepository;

    public function __construct(Saver $saver, Observer $observer, EntityRepository $entityRepository) {
        $this->saver = $saver;
        $this->observer = $observer;
        $this->entityRepository = $entityRepository;
    }

    public function performAction()
    {
        $this->saver->delete($this->observer);
        $this->entityRepository->detach($this->getSubject());
    }

    public function getSubject()
    {
        return $this->observer->getSubject();
    }

    public function hasNeedForAction()
    {
        return true;
    }

    public function subjectExistsAfterPerformAction()
    {
        return false;
    }
}