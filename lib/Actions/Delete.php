<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\observer\Observer;

class Delete implements Action
{
    private $subject;
    private $entityRepository;

    public function __construct(Managable $subject, EntityRepository $entityRepository) {
        $this->subject = $subject;
        $this->entityRepository = $entityRepository;
    }

    public function performAction(Saver $saver)
    {
        $saver->delete($this->getSubject());
        $this->entityRepository->detach($this->getSubject());
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function subjectExistsAfterPerformAction()
    {
        return false;
    }
}