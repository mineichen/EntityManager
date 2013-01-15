<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;

class Delete implements Action
{
    private $saver;
    private $subject;
    private $identityMap;

    public function __construct(Saver $saver, Managable $subject, IdentityMap $identityMap) {
        $this->saver = $saver;
        $this->subject = $subject;
        $this->identityMap = $identityMap;
    }

    public function performAction()
    {
        $this->saver->delete(
            $this->subject
        );
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function hasNeedForAction()
    {
        return true;
    }

    public function getActionType()
    {
        return 'delete';
    }

    public function commitAfterExecution()
    {
        return false;
    }
}