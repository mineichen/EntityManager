<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\Exception;
use mineichen\entityManager\Saver;
use mineichen\entityManager\observer\Generator as ObserverFactory;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;

class Factory 
{
    private $complementer;
    private $observerFactory;
    private $saver;
    
    public function __construct(ObserverFactory $observerFactory, Saver $saver, Complementer $complementer = null)
    {
        $this->observerFactory = $observerFactory;
        $this->saver = $saver;
        $this->complementer = $complementer;
    }
    
    public function getInstanceFor(Managable $subject, $type, IdentityMap $identityMap)
    {
        switch ($type) {
            case 'create':
                return new Create(
                    $subject, 
                    $this->saver,
                    $identityMap
                );
            case 'update':
                return new Update(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $identityMap,
                    $this->complementer
                );
            case 'delete':
                return new Delete(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $identityMap
                );
        }
    }

    protected function getClassNameForType($type)
    {
        switch ($type) {
            case 'create':
                return __NAMESPACE__ . '\\Create';
            case 'update':
                return __NAMESPACE__ . '\\Update';
            case 'delete':
                return __NAMESPACE__ . '\\Delete';
        }
        throw new Exception(sprintf('No actionClass found for type "%s"', $type));
    }
}
