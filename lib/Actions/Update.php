<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;

class Update implements Action
{
    private $subject;

    public function __construct(Managable $subject)
    {
        $this->subject = $subject;
    }

    public function getType()
    {
        return 'update';
    }

    public function getSubject()
    {
        return $this->subject;
    }
    
    public function subjectExistsAfterPerformAction()
    {
        return true;
    }

    public function getNextAction()
    {
        return $this;
    }
}