<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\entityObserver\Observer;
use mineichen\entityManager\Saver;

class Create implements Action
{
    private $subject;
    private $saver;
    
    public function __construct(Managable $subject, Saver $saver)
    {
        $this->subject = $subject;
        $this->saver = $saver;
    }
    
    public function performAction()
    {
        $this->saver->create($this->subject);
    }
    
    public function hasNeedForAction()
    {
        return true;
    }
    
    public function getActionType()
    {
        return 'update';
    }
    
    public function commitAfterExecution()
    {
        return true;
    }
}