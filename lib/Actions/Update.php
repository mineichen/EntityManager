<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\entityObserver\Observer;
use mineichen\entityManager\Saver;

class Update implements Action
{
    private $saver;
    private $observer;
    
    public function __construct(Saver $saver, Observer $observer) {
        $this->saver = $saver;
        $this->observer = $observer;
    }
    
    public function performAction()
    {
        if ($this->hasNeedForAction()) {
            return $this->saver->update(
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