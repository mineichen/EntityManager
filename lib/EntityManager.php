<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\RepositoryRecord;

class EntityManager 
{
    private $repos = array();

    public function addRepository(repository\EntityRepository $repo)
    {
        $this->repos[$repo->getEntityType()] = $repo;
        $repo->setEntityManager($this);
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
    
    public function persist(repository\Managable $subject)
    {
        $this->getRepository($subject->getType())->persist($subject);
    }
    
    public function find($type, $id) 
    {
        return $this->getRepository($type)->find($id);
    }
    
    public function isRegistered(repository\Managable $subject)
    {
        return $this->getRepository($subject->getType())->isRegistered($subject);
    }
    
    public function hasNeedForFlush()
    {
        foreach($this->repos as $repo) {
            if ($repo->hasNeedForFlush()) {
                return true;
            }
        }
        
        return false;
    }
    
    public function flushEntity(repository\Managable $subject)
    {
        $this->getRepository($subject->getType())->flushEntity($subject);
    }
    
    public function flush()
    {
        foreach ($this->createPriorityQueueGenerator()->createQueue() as $entity) {
            $this->flushEntity($entity);
        }
    }

    protected function createPriorityQueueGenerator()
    {
        $generator = new ActionPriorityGenerator();

        $this->resolveAllDependencies();

        foreach ($this->repos as $repo) {
            $repo->appendChangesTo($generator);
        }

        return $generator;
    }

    protected function resolveAllDependencies()
    {
        foreach($this->repos as $repo) {
            foreach ($repo->getDirtyRecords() as $record) {
                $this->resolveDependencies($record);
            }
        }
    }
    
    protected function resolveDependencies(RepositoryRecord $record)
    {
        $subject = $record->getSubject();
    
        if (!($subject instanceof DependencyAware)) {
            return;
        }
        
        foreach ($subject->getDependencies() as $dependency) {
            $this->persist($dependency);
        }
    }
}

