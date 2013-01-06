<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\entityObserver\Observer;
use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\Saver;

class Update implements Action
{
    private $subject;
    private $saver;
    private $observer;
    
    public function __construct(Observable $subject, Saver $saver, Observer $observer) {
        $this->subject = $subject;
        $this->saver = $saver;
        $this->observer = $observer;
    }
    
    public function performAction()
    {
        if ($this->hasNeedForAction()) {
            return $this->saver->update(
                //$subject,
                $this->observer
            );
        }
    }
    
    public function hasNeedForAction()
    {
        return $this->observer->hasDiffs();
    }
    
    public function getActionType()
    {
        return 'update';
    }
    
    public function commitAfterExecution()
    {
        return false;
    }
}