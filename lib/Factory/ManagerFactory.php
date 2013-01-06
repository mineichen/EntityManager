<?php

namespace mineichen\entityManager;

abstract class ManagerFactory 
{
    private $observerFactory;
    
    public function createManager() 
    {
        $manager = new EntityManager();
        $this->appendRepositories($manager);
        return $manager;
    }
    
    protected function getDefaultRepository($entityType, Saver $backend, Loader $loader)
    {
        return new EntityRepository(
            $loader,
            $this->getRecordManager($backend, $entityType)
        );
    }
    
    protected function getRecordManager($saver, $entityType)
    {
        return new RecordManager(
            $this->getRepositoryRecordGenerator($saver),
            $entityType
        );
    }
    
    protected function getRepositoryRecordGenerator($saver)
    {
        return new RepositoryRecordGenerator(
            $this->getActionFactory($saver)
        );
    }
    
    protected function getActionFactory(Saver $saver)
    {
        return new actions\Factory(
            $this->getObserverFactory(),
            $saver
        );
    }
    
    protected function getObserverFactory()
    {
        if (!$this->observerFactory) {
            $this->observerFactory = new entityObserver\asArray\Factory();
        }
        
        return $this->observerFactory;
    }
    
    abstract protected function appendRepositories(EntityManager $manager);
}
