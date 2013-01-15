<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\Saver;

class Delete implements Action
{
    private $saver;
    private $subject;

    public function __construct(Saver $saver, Managable $subject) {
        $this->saver = $saver;
        $this->subject = $subject;
    }

    public function performAction()
    {
        return $this->saver->delete(
            $this->subject
        );
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