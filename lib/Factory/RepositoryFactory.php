<?php

namespace mineichen\entityManager;

class RepositoryFactory
{
    private $observerFactory;
    
    public function get($entityType, Saver $saver, Loader $loader, $complementer = null)
    {
        $repo = new repository\RepositorySandbox(
            $this->getIdentityMap($saver, $complementer),
            $entityType,
            $loader
        );

        return $repo;
    }


    
    protected function getIdentityMap(Saver $saver, $complementer)
    {
        return new repository\IdentityMap(
            $this->getActionFactory($saver, $complementer)
        );
    }
    
    protected function getActionFactory(Saver $saver, $complementer)
    {
        $factory = new action\Factory(
            $this->getObserverFactory(),
            $saver
        );

        $factory->setComplementer($complementer);

        return $factory;
    }
    
    protected function getObserverFactory()
    {
        if (!$this->observerFactory) {
            $this->observerFactory = new entityObserver\asArray\Generator();
        }
        
        return $this->observerFactory;
    }
}
