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
    
    public function __construct(Managable $subject, EntityRepository $entityRepository)
    {
        $this->subject = $subject;
        $this->entityRepository = $entityRepository;
    }

    public function performAction(Saver $saver)
    {
        $saver->create($this->subject);
        $this->entityRepository->attach($this->subject, 'update');
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