<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\plugin;

class RepositoryFactory
{
    public function create($entityType, Loader $loader, array $plugins = [])
    {
        $repo = new repository\EntityRepository(
            $this->getIdentityMap(),
            $entityType,
            $loader,
            $this->getActionFactory()
        );

        foreach($plugins as $plugin) {
            $repo->addPlugin($plugin);
        }

        return $repo;
    }

    public function createWithConfig(array $config)
    {
        return $this->create(
            $config['entityType'],
            $config['loader'],
            (array_key_exists('plugins', $config) ? $config['plugins'] : [])
        );
    }

    protected function getIdentityMap()
    {
        return new repository\IdentityMap();
    }

    protected function getActionFactory()
    {
        return new action\Factory();
    }
}
