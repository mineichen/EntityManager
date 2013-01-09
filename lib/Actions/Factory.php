<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\Exception;
use mineichen\entityManager\Saver;
use mineichen\entityManager\entityObserver\Factory as ObserverFactory;

class Factory 
{
    private $observerFactory;
    private $saver;
    
    public function __construct(ObserverFactory $observerFactory, Saver $saver)
    {
        $this->observerFactory = $observerFactory;
        $this->saver = $saver;
    }
    
    public function getInstanceFor($subject, $type)
    {
        switch ($type) {
            case 'create':
                return new \mineichen\entityManager\actions\Create(
                    $subject, 
                    $this->saver
                );
            case 'update':
                return new \mineichen\entityManager\actions\Update(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject)
                );
        }
        
        throw new Exception(sprintf('No action found for type "%s"', $type));
    }
}
