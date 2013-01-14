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
    
    protected function getRepositorySandbox($entityType, Saver $saver, Loader $loader)
    {
        return new repository\RepositorySandbox(
            $this->getRepositoryRecordGenerator($saver),
            $entityType,
            $loader
        );
    }
    
    public function getRepositoryRecordGenerator(Saver $saver)
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
    
    protected function appendRepositories(EntityManager $manager)
    {

    }
}
