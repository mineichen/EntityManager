<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\plugin;

class RepositoryFactory
{
    private $manager;
    private $defaultPlugins;

    public function __construct(EntityManager $manager, array $defaultPlugins = ['Dependency'])
    {
        $this->manager = $manager;
        $this->defaultPlugins = $defaultPlugins;
    }
    
    public function add($entityType, Loader $loader, array $plugins = [])
    {
        $repo = new repository\EntityRepository(
            $this->getIdentityMap(),
            $entityType,
            $loader,
            $this->getActionFactory()
        );

        foreach(array_merge($this->defaultPlugins, $plugins) as $plugin) {
            $repo->addPlugin($this->getPlugin($plugin, $loader));
        }

        $this->manager->addRepository($repo);

        return $repo;
    }

    public function addWithConfig(array $configs)
    {
        foreach ($configs as $config) {
            $this->add(
                $config['entityType'],
                $config['loader'],
                (array_key_exists('plugins', $config) ? $config['plugins'] : [])
            );
        }
    }

    protected function getPlugin($name, $loader)
    {
        if($name instanceof plugin\Plugin) {
            return $name;
        }

        switch($name) {
            case 'Dependency':
                return new plugin\DependencyPlugin($this->manager);
            case 'Complementer':
                return new plugin\ComplementerPlugin(new proxy\TraitComplementer($loader));
        }

        if (is_string($name)) {
            throw new Exception(sprintf('Instance for "%s" not found', $name));
        }

        throw new Exception('Expect $type to be String');
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
