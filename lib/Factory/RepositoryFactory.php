<?php

namespace mineichen\entityManager;

class RepositoryFactory
{
    private $observerFactory;
    
    public function get($entityType, Saver $saver, Loader $loader, proxy\Complementer $complementer = null)
    {
        $repo = new repository\RepositorySandbox(
            $this->getIdentityMap($saver, $complementer),
            $entityType,
            $loader
        );

        return $repo;
    }

    protected function getIdentityMap(Saver $saver, proxy\Complementer $complementer = null)
    {
        return new repository\IdentityMap(
            $this->getActionFactory($saver, $complementer)
        );
    }
    
    protected function getActionFactory(Saver $saver, proxy\Complementer $complementer = null)
    {
        return new action\Factory(
            $this->getObserverFactory(),
            $saver,
            $complementer
        );
    }
    
    protected function getObserverFactory()
    {
        if (!$this->observerFactory) {
            $this->observerFactory = new observer\asArray\Generator();
        }
        
        return $this->observerFactory;
    }
}
