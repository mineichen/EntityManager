<?php

namespace mineichen\entityManager;

class RepositoryFactory
{
    private $observerFactory;
    
    public function get($entityType, Saver $saver, Loader $loader, $complementer = null)
    {
        $repo = new repository\RepositorySandbox(
            $this->getIdentityMap($saver),
            $entityType,
            $loader
        );

        if ($complementer) {
            $repo->setComplementer($complementer);
        }

        return $repo;
    }
    
    protected function getIdentityMap(Saver $saver)
    {
        return new repository\IdentityMap(
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
}
