<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\Loader;
use mineichen\entityManager\EntityManager;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\proxy\Complementable;
use mineichen\entityManager\proxy\Complementer;

class EntityRepository
{
    /**
     * @var \mineichen\entityManager\Loader
     */
    private $loader;
    
    /**
     * @var \mineichen\entityManager\RepositorySandbox
     */
    private $sandbox;
    private $complementer;
    private $manager;
    
    public function __construct(Loader $loader, RepositorySandbox $sandbox)
    {
        $this->loader = $loader;
        $this->sandbox = $sandbox;
    }

    public function setComplementer(Complementer $complementer)
    {
        $this->complementer = $complementer;
    }

    public function getComplementer()
    {
        if (!($this->complementer instanceof Complementer)) {
            throw new \mineichen\entityManager\Exception('Complementer not Found');
        }
        return $this->complementer;
    }

    public function persist(Managable $subject)
    {
        $this->getSandbox()->attach($subject, 'create');
    }
    
    public function setEntityManager(EntityManager $manager)
    {
        $this->manager = $manager;
        
        if (!$manager->hasRepository($this->getEntityType())) {
            $this->manager->addRepository($this);
        }
    }
    
    public function find($id)
    {
        return $this->getSandbox()->find($id, $this->loader);
    }

    public function complement(Complementable $proxy)
    {
        $this->loader->complement($proxy);
    }

    public function findBy(array $config)
    {
        $entities = $this->loader->findBy($config);
        array_walk(
            $entities,
            function($entity) {
                if ($entity instanceof Complementable) {
                    $entity->setComplementer($this->complementer);
                }
            }
        );

        return $entities;
    }
    
    public function isRegistered(Managable $subject)
    {
        return $this->getSandbox()->isRegistered($subject);
    }
    
    public function hasNeedForFlush()
    {
        return (bool) $this->getSandbox()->getDirtyRecords();
    }

    public function getDirtyRecords()
    {
        return $this->getSandbox()->getDirtyRecords();
    }
    
    public function flushEntity(Managable $subject)
    {
        $this->getSandbox()->performAction($subject);
    }
    
    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        $this->getSandbox()->appendChangesTo($generator);
    }
    
    public function getEntityType()
    {
        return $this->getSandbox()->getEntityType();
    }

    protected function getSandbox()
    {
        return $this->sandbox;
    }
    
    protected function getEntityManager()
    {
        if (!($this->manager instanceof EntityManager)) {
            throw new Exception('Repository needs to be linked with a Manager to perform this Action!');
        }
        
        return $this->manager;
    }
}