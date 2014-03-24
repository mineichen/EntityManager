<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\observer\Observer;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;
use mineichen\entityManager\event;

class Update implements Action
{
    private $entityRepository;
    private $saver;
    private $observer;

    public function __construct(Saver $saver, Observer $observer, EntityRepository $entityRepository) {
        $this->saver = $saver;
        $this->observer = $observer;
        $this->entityRepository = $entityRepository;
    }

    public function performAction()
    {
        if ($this->hasNeedForAction()) {
            $this->saver->update($this->observer);
            $this->entityRepository->attach($this->getSubject(), 'update');
        }
    }

    public function getSubject()
    {
        return $this->observer->getSubject();
    }
    
    public function hasNeedForAction()
    {
        return $this->observer->hasDiffs();
    }

    public function subjectExistsAfterPerformAction()
    {
        return true;
    }
}