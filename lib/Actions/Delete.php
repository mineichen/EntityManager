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

    public function __construct(Managable $subject) {
        $this->subject = $subject;
    }

    public function getType()
    {
        return 'delete';
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function subjectExistsAfterPerformAction()
    {
        return false;
    }

    public function getNextAction()
    {
        return;
    }
}