<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\entity\Managable;

class Create implements Action
{
    private $nextActionClass;
    private $subject;
    
    public function __construct(Managable $subject, $nextActionClass)
    {
        $this->subject = $subject;
        $this->nextActionClass = $nextActionClass;
    }

    public function getType()
    {
        return 'create';
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
        return new $this->nextActionClass($this->subject);
    }
}