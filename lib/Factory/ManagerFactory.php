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
        return new repository\EntityRepository(
            $loader,
            $this->getRepositorySandbox($backend, $entityType)
        );
    }
    
    protected function getRepositorySandbox($saver, $entityType)
    {
        return new repository\RepositorySandbox(
            $this->getRepositoryRecordGenerator($saver),
            $entityType
        );
    }
    
    protected function getRepositoryRecordGenerator($saver)
    {
        return new repository\RepositoryRecordGenerator(
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
            $this->observerFactory = new entityObserver\asArray\Generator();
        }
        
        return $this->observerFactory;
    }
    
    abstract protected function appendRepositories(EntityManager $manager);
}
