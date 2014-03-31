<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\repository\plugin\Plugin;

class EntityManager
{
    /**
     * @var array
     */
    private $repos = array();
    private $plugins = array();

    public function addRepository(EntityRepository $repo)
    {
        foreach($this->plugins as $plugin) {
            $repo->addPlugin($plugin);
        }
        $this->repos[$repo->getEntityType()] = $repo;
        return $repo;
    }

    public function addPlugin(Plugin $plugin)
    {
        foreach($this->repos as $repo) {
            $repo->addPlugin($plugin);
        }
        $this->plugins[] = $plugin;
    }

    public function getRepository($type)
    {
        if (!$this->hasRepository($type)) {
            throw new Exception(sprintf('Kein Repository für den Type "%s" vorhanden', $type));
        }
        
        return $this->repos[$type];
    }

    public function hasRepository($type)
    {
        return array_key_exists($type, $this->repos);
    }
    
    public function persist(entity\Managable $subject)
    {
        $this->getRepository($subject->getType())->persist($subject);
    }

    public function delete(entity\Managable $subject)
    {
        $this->getRepository($subject->getType())->delete($subject);
    }

    public function contains(entity\Managable $subject)
    {
        $this->getRepository($subject->getType())->contains($subject);
    }

    public function find($type, $id)
    {
        return $this->getRepository($type)->find($id);
    }

    public function __call($method, array $args)
    {
        return call_user_func_array(
            [$this->getRepository(array_shift($args)), $method],
            $args
        );
    }
    
    public function isRegistered(entity\Managable $subject)
    {
        return $this->getRepository($subject->getType())->isRegistered($subject);
    }
    
    public function flush()
    {
        foreach($this->repos as $repo) {
            $repo->flush();
        }
    }

    public function flushEntity(entity\Managable $subject)
    {
        $this->getRepository($subject->getType())->flushEntity($subject);
    }
}

