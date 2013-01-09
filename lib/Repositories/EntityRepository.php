<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\Loader;
use mineichen\entityManager\EntityManager;
use mineichen\entityManager\ActionPriorityGenerator;

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
    
    private $manager;
    
    public function __construct(Loader $loader, RepositorySandbox $sandbox)
    {
        $this->loader = $loader;
        $this->sandbox = $sandbox;
    }        
    
    public function persist(Managable $subject)
    {
        $this->attach($subject, 'create');
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
        $subject = $this->fetchSubjectForId($id);
        
        if ($subject === false) {
            $subject = $this->loader->load($id);
            $this->attach($subject, 'update');
        }
        
        return $subject;
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
    
    protected function attach($subject, $actionType)
    {
        $this->getSandbox()->attach($subject, $actionType);
    }
    
    protected function fetchSubjectForId($id)
    {
        return $this->getSandbox()->fetchSubjectForId($id);
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