<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\observer\Observer;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;
use mineichen\entityManager\event;

class Update implements Action
{
    private $entityRepository;
    private $subject;

    public function __construct(Managable $subject, EntityRepository $entityRepository) {
        $this->subject = $subject;
        $this->entityRepository = $entityRepository;
    }

    public function performAction(Saver $saver)
    {
        $saver->update($this->subject);
        $this->entityRepository->attach($this->getSubject(), 'update');
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