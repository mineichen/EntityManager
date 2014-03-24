<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\EntityRepository;

class EntityManager
{
    /**
     * @var array
     */
    private $repos = array();

    public function addRepository(EntityRepository $repo)
    {
        $this->repos[$repo->getEntityType()] = $repo;
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

    public function findBy($type, array $config)
    {
        return $this->getRepository($type)->findBy($config);
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

