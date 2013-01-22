<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\EntityManager;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\Loader;


class EntityRepository implements Repository
{
    /**
     * @var IdentityMap
     */
    private $identityMap;
    
    /**
     * @var string
     */
    private $entityType;

    /**
     * @var \mineichen\entityManager\EntityManager
     */
    private $manager;

    /**
     * @param IdentityMap $identityMap
     * @param $entityType
     * @param \mineichen\entityManager\Loader $loader
     */
    public function __construct(IdentityMap $identityMap, $entityType, Loader $loader)
    {
        $this->identityMap = $identityMap;
        $this->entityType = $entityType;
        $this->loader = $loader;
    }

    /**
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    public function persist(Managable $subject)
    {
        $this->attach($subject, 'create');
    }

    public function delete(Managable $subject)
    {
        $this->identityMap->attach($subject, 'delete');
    }

    public function find($id)
    {
        $subject = $this->fetchSubjectForId($id);

        if ($subject === false) {
            $subject = $this->loader->find($id);
            $this->attach($subject, 'update');
        }

        return $subject;
    }

    public function findBy(array $config = array())
    {
        return array_map(
            function($newEntity) {
                $existing = $this->fetchSubjectForId($newEntity->getId());
                if ($existing !== false) {
                    return $existing;
                }

                $this->attach($newEntity, 'update');
                return $newEntity;
            },
            $this->loader->findBy($config)
        );
    }

    public function flushEntity(Managable $subject)
    {
        $this->identityMap->getActionFor($subject)->performAction();
    }

    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        $this->identityMap->appendChangesTo($generator);
    }

    private function fetchSubjectForId($id)
    {
        $result = $this->identityMap->getSubjectsForId($id);
        
        switch (count($result)) {
            case 0:
                return false;
            case 1;
                return array_values($result)[0];
            default:
                throw new Exception(sprintf('Multiple Instances with same ID "%s" registered!', $id));
        }
    }
    
    public function getDirtyActions()
    {
        return array_map(
            function($subject) {
                return $this->identityMap->getActionFor($subject);
            }, 
            $this->getDirtySubjects()
        );
    }
    
    private function getDirtySubjects()
    {  
        return array_filter(
            $this->identityMap->asArray(),
            function(Managable $subject) {
                return $this->identityMap->getActionFor($subject)->hasNeedForAction();
            }
        );
    }
    
    public function isRegistered(Managable $subject)
    {
        return $this->matchesType($subject)
            && $this->identityMap->hasActionFor($subject);
    }

    public function hasNeedForFlush()
    {
        return (bool) $this->getDirtyActions();
    }


    /**
     * @param Managable $subject
     * @param $actionType
     * @return \mineichen\entityManager\action\Action
     */
    private function attach(Managable $subject, $actionType)
    {
        if ($action = $this->identityMap->hasActionFor($subject)) {
            return $this->identityMap->getActionFor($subject);
        }

        return $this->identityMap->attach($subject, $actionType);
    }

    private function matchesType(Managable $subject)
    {
        return $subject->getType() === $this->entityType;
    }

    public function setEntityManager(EntityManager $manager)
    {
        $this->manager = $manager;

        if (!$manager->hasRepository($this->getEntityType())) {
            $this->manager->addRepository($this);
        }
    }

    public function getEntityManager()
    {
        if (!($this->manager instanceof EntityManager)) {
            throw new Exception('Repository needs to be linked with a Manager to perform this Action!');
        }

        return $this->manager;
    }
}
