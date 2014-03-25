<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\action\Factory;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\event\Dispatcher;
use mineichen\entityManager\event\ObservableTrait;
use mineichen\entityManager\Exception;
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

    private $actionFactory;

    private $managePlugins = [];
    private $flushPlugins = [];
    private $extendedFlushPlugins = [];
    private $actionTypes = [
        'create' => 'mineichen\\entityManager\\action\\Create',
        'update' => 'mineichen\\entityManager\\action\\Update',
        'delete' => 'mineichen\\entityManager\\action\\Delete',
    ];

    /**
     * @param IdentityMap $identityMap
     * @param $entityType
     * @param \mineichen\entityManager\Loader $loader
     */
    public function __construct(IdentityMap $identityMap, $entityType, Loader $loader, Factory $actionFactory)
    {
        $this->identityMap = $identityMap;
        $this->entityType = $entityType;
        $this->loader = $loader;
        $this->actionFactory = $actionFactory;
    }

    public function addPlugin(plugin\Plugin $plugin)
    {
        if ($plugin instanceof plugin\ManagePlugin) {
            $this->managePlugins[] = $plugin;
        }

        if($plugin instanceof plugin\ExtendedFlushPlugin) {
            $this->extendedFlushPlugins[] = $plugin;
        }

        if($plugin instanceof plugin\FlushPlugin) {
            $this->flushPlugins[] = $plugin;
        }
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
                    return $existing;
                }

                $this->attach($newEntity, 'update');
                return $newEntity;
            },
            $this->loader->findBy($config)
        );
    }

    public function flush()
    {
        foreach($this->identityMap as $subject) {
            $this->flushEntity($subject);
        }
    }

    public function flushEntity(Managable $subject)
    {
        $action = $this->identityMap->getActionFor($subject);
        foreach($this->extendedFlushPlugins as $plugin) {
            $plugin->beforeFlush($action);
        }
        foreach($this->flushPlugins as $plugin) {
            $plugin->onFlush($action);
        }
        foreach($this->extendedFlushPlugins as $plugin) {
            $plugin->afterFlush($action);
        }

        if($action->subjectExistsAfterPerformAction()) {
            $this->identityMap->attach($action->getNextAction());
        } else {
            $this->detach($subject);
        }
    }

    private function fetchSubjectForId($id)
    {
        foreach($this->identityMap as $subject) {
            if($subject->hasId() && $subject->getId() === $id) {
                return $subject;
            }
        }
        return false;
    }
    


    public function isRegistered(Managable $subject)
    {
        return $this->matchesType($subject)
            && $this->identityMap->hasActionFor($subject);
    }


    /**
     * @param Managable $subject
     * @param $actionType
     */
    public function attach(Managable $subject, $actionType)
    {
        $this->assertSupport($subject);

        $action =  $this->actionFactory->getInstanceFor($subject, $actionType, $this);

        if(!$this->identityMap->hasActionFor($subject)) {
            foreach($this->managePlugins as $plugin) {
                $plugin->onAttach($subject);
            }
        }

        $this->identityMap->attach($action);
    }

    public function contains(Managable $subject)
    {
        return $this->identityMap->hasActionFor($subject);
    }

    public function detach(Managable $subject)
    {
        if(!$this->identityMap->hasActionFor($subject)) {
            throw new Exception(sprintf(
                'Subject from type="%s" and id="%s" does\'t exist',
                $subject->getType(),
                $subject->getId()
            ));
        }

        foreach($this->managePlugins as $plugin) {
            $plugin->onDetach($subject);
        }

        $this->identityMap->detach($subject);
    }

    protected function matchesType(Managable $subject)
    {
        return $subject->getType() === $this->entityType;
    }

    protected function assertSupport(Managable $subject)
    {
        if(!$this->matchesType($subject)) {
            throw new Exception(sprintf(
                'Subject with type "%s" is not supported in Repository with type "%s"',
                $subject->getType(),
                $this->getEntityType()
            ));
        }
    }
}
