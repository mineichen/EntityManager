<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\entityObserver\Observer;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;

class Update implements Action
{
    private $identityMap;
    private $saver;
    private $observer;
    
    public function __construct(Saver $saver, Observer $observer, IdentityMap $identityMap) {
        $this->saver = $saver;
        $this->observer = $observer;
        $this->identityMap = $identityMap;
    }
    
    public function performAction()
    {
        if ($this->hasNeedForAction()) {
            $this->saver->update(
                $this->observer
            );
            $this->identityMap->attach($this->getSubject(), 'update');
        }
    }

    public function getSubject()
    {
        return $this->observer->getSubject();
    }
    
    public function hasNeedForAction()
    {
        return $this->observer->hasDiffs();
    }
    
    public function commitAfterExecution()
    {
        return false;
    }
}