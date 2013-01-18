<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\observer\Observer;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementable;
use mineichen\entityManager\proxy\Complementer;

class Update implements Action
{
    private $identityMap;
    private $saver;
    private $observer;

    public function __construct(Saver $saver, Observer $observer, IdentityMap $identityMap, Complementer $complementer = null) {
        $this->saver = $saver;
        $this->observer = $observer;
        $this->identityMap = $identityMap;

        // @todo Remove Complementer Instanceof
        if ($observer->getSubject() instanceof Complementable && $complementer instanceof \mineichen\entityManager\proxy\Complementer) {
            $observer->getSubject()->setComplementer($complementer);
        }
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
}