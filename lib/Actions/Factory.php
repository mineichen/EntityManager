<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\Exception;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\observer\Generator as ObserverFactory;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;

class Factory 
{
    private $observerFactory;
    private $saver;
    
    public function __construct(ObserverFactory $observerFactory, Saver $saver)
    {
        $this->observerFactory = $observerFactory;
        $this->saver = $saver;
    }
    
    public function getInstanceFor(Managable $subject, $type, EntityRepository $entityRepository)
    {
        switch ($type) {
            case 'create':
                return new Create(
                    $subject, 
                    $this->saver,
                    $entityRepository
                );
            case 'update':
                return new Update(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $entityRepository
                );
            case 'delete':
                return new Delete(
                    $this->saver,
                    $this->observerFactory->getInstanceFor($subject),
                    $entityRepository
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
