<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;

class Create implements Action
{
    private $entityRepository;
    private $subject;
    private $saver;
    
    public function __construct(Managable $subject, Saver $saver, EntityRepository $entityRepository)
    {
        $this->subject = $subject;
        $this->saver = $saver;
        $this->entityRepository = $entityRepository;
    }

    public function performAction()
    {
        $this->saver->create($this->subject);
        $this->entityRepository->attach($this->subject, 'update');
    }
    
    public function hasNeedForAction()
    {
        return true;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function subjectExistsAfterPerformAction()
    {
        return true;
    }
}