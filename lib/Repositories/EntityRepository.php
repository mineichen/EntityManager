<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;

class EntityRepository 
{
    /**
     * @var \mineichen\entityManager\Loader
     */
    private $loader;
    
    /**
     * @var \mineichen\entityManager\RecordManager
     */
    private $recordManager;
    
    private $manager;
    
    public function __construct(Loader $loader, RecordManager $recordManager)
    {
        $this->loader = $loader;
        $this->recordManager = $recordManager;
    }        
    
    public function persist(Observable $subject)
    {
        $this->attach($subject, 'create');
    }
    
    public function setEntityManager(EntityManager $manager)
    {
        $this->manager = $manager;
        
        if (!$manager->hasRepository($this->getEntityType()) != null) {
            $this->manager->addRepository($this);
        }
    }
    
    public function find($id)
    {
        $record = $this->fetchSubjectForId($id);
        
        if ($record !== false) {
            return $record;
        }
        //echo PHP_EOL . PHP_EOL . 'LOADED' . PHP_EOL . PHP_EOL;
        $entity = $this->loader->load($id);
        $this->attach($entity, 'update');
        
        return $entity;
    }
    
    public function isRegistered(Observable $subject)
    {
        return $this->getRecordManager()->isRegistered($subject);
    }
    
    public function hasNeedForFlush()
    {
        return (bool) $this->getRecordManager()->getDirtyRecords();
    }
    
    public function getDirtyRecords()
    {
        return $this->getRecordManager()->getDirtyRecords();
    }
    
    public function flushEntity(Observable $observable)
    {
        $this->getRecordManager()->performAction($observable);
    }
    
    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        $this->getRecordManager()->appendChangesTo($generator);
    }
    
    public function getEntityType()
    {
        return $this->getRecordManager()->getEntityType();
    }
    
    protected function attach($subject, $actionType)
    {
        $this->getRecordManager()->attach($subject, $actionType);
        $this->getRecordManager()->attach($subject, $actionType);
    }
    
    protected function fetchSubjectForId($id)
    {
        return $this->getRecordManager()->fetchSubjectForId($id);
    }
    
    protected function getRecordManager()
    {
        return $this->recordManager;
    }
    
    protected function getEntityManager()
    {
        if (!($this->manager instanceof EntityManager)) {
            throw new Exception('Repository wurde mit keinem Manager Verknüpft!');
        }
        
        return $this->manager;
    }
}