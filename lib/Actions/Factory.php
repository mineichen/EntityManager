<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\Exception;
use mineichen\entityManager\Saver;
use mineichen\entityManager\entityObserver\Generator as ObserverFactory;
use mineichen\entityManager\actions;
use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;

class Factory 
{
    private $complementer;
    private $observerFactory;
    private $saver;
    
    public function __construct(ObserverFactory $observerFactory, Saver $saver)
    {
        $this->observerFactory = $observerFactory;
        $this->saver = $saver;
    }
    
    public function getInstanceFor(Managable $subject, $type, IdentityMap $identityMap)
    {
        switch ($type) {
            case 'create':
                return new actions\Create(
                    $subject, 
                    $this->saver,
                    $identityMap
                );
            case 'update':
                return new actions\Update(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $identityMap,
                    $this->complementer
                );
            case 'delete':
                return new actions\Delete(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $identityMap
                );
        }
        
        throw new Exception(sprintf('No action found for type "%s"', $type));
    }

    public function setComplementer($complementer)
    {
        $this->complementer = $complementer;
    }
}
