<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\EntityManager;
use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\proxy\Complementable;
use mineichen\entityManager\proxy\Complementer;
use mineichen\entityManager\Loader;


class RepositorySandbox implements Repository
{
    /**
     * @var \SplObjectStorage
     */
    private $records;
    
    /**
     * @var \mineichen\entityManager\repository\RepositoryRecordGenerator
     */
    private $recordGenerator;
    
    /**
     * @var string
     */
    private $entityType;

    /**
     * @var Complementer
     */
    private $complementer;

    /**
     * @var \mineichen\entityManager\EntityManager
     */
    private $manager;

    /**
     * @param RepositoryRecordGenerator $recordGenerator
     * @param $entityType
     * @param \mineichen\entityManager\Loader $loader
     */
    public function __construct(RepositoryRecordGenerator $recordGenerator, $entityType, Loader $loader)
    {
        $this->identityMap = new IdentityMap();
        $this->recordGenerator = $recordGenerator;
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
        $this->attach($subject, 'delete');
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

    public function findBy(array $config)
    {
        return array_map(
            function($newEntity) {
                $existing = $this->fetchSubjectForId($newEntity->getId());
                if ($existing !== false) {
                    //echo 'Load existing one more Time';
                    return $existing;
                }

                if ($newEntity instanceof Complementable) {
                    $newEntity->setComplementer($this->complementer);
                }

                $this->attach($newEntity, 'update');
                return $newEntity;
            },
            $this->loader->findBy($config)
        );
    }

    public function flushEntity(Managable $subject)
    {
        $this->identityMap->getRecordFor($subject)->performAction();
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
                throw new Exception(sprintf('Multiple Records with same ID "%s" registered!', $id));
        }
    }
    
    public function getDirtyRecords()
    {
        return array_map(
            function($subject) {
                return $this->identityMap->getRecordFor($subject);
            }, 
            $this->getDirtySubjects()
        );
    }
    
    private function getDirtySubjects()
    {  
        return array_filter(
            $this->identityMap->asArray(),
            function(Managable $subject) {
                return $this->identityMap->getRecordFor($subject)->isDirty();
            }
        );
    }
    
    public function isRegistered(Managable $subject)
    {
        return $this->matchesType($subject)
            && $this->hasRecordFor($subject);
    }

    public function hasNeedForFlush()
    {
        return (bool) $this->getDirtyRecords();
    }
    


    private function attach(Managable $subject, $actionType)
    {
        if ($this->hasRecordFor($subject)) {
            return;
        }

        $this->identityMap->attach(
            $this->recordGenerator->create($subject, $actionType)
        );
    }

    private function hasRecordFor(Managable $subject)
    {
        return $this->identityMap->hasRecordFor($subject);
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

    public function setComplementer(Complementer $complementer)
    {
        $this->complementer = $complementer;
    }

    public function getComplementer()
    {
        if (!($this->complementer instanceof Complementer)) {
            throw new \mineichen\entityManager\Exception('Complementer not Found');
        }
        return $this->complementer;
    }
}
