<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\action\Factory;
use mineichen\entityManager\EntityManager;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\ActionPriorityGenerator;
use mineichen\entityManager\event\Dispatcher;
use mineichen\entityManager\event\ObservableTrait;
use mineichen\entityManager\Exception;
use mineichen\entityManager\Loader;
use mineichen\entityManager\repository\Plugin\FlushPlugin;
use mineichen\entityManager\repository\Plugin\ManagePlugin;


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
        if ($plugin instanceof ManagePlugin) {
            $this->managePlugins[] = $plugin;
        }

        if($plugin instanceof FlushPlugin) {
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
        foreach($this->flushPlugins as $plugin) {
            $plugin->onFlush($action);
        }
        $action->performAction();
        foreach($this->flushPlugins as $plugin) {
            $plugin->afterFlush($action);
        }
    }

    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        foreach($this->identityMap as $subject) {
            $generator->appendSubject($subject);
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

    public function hasNeedForFlush()
    {
        foreach($this->identityMap as $subject) {
            if($this->identityMap->getActionFor($subject)->hasNeedForAction()) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param Managable $subject
     * @param $actionType
     */
    public function attach(Managable $subject, $actionType)
    {
        if(!$this->matchesType($subject)) {
            throw new Exception(sprintf(
                'Subject with type "%s" is not supported in Repository with type "%s"',
                $subject->getType(),
                $this->getEntityType()
            ));
        }

        if($this->identityMap->hasActionFor($subject)) {
            $this->detach($subject);
        }

        $action =  $this->actionFactory->getInstanceFor($subject, $actionType, $this);
        foreach($this->managePlugins as $plugin) {
            $plugin->onAttach($subject, $actionType);
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

    private function matchesType(Managable $subject)
    {
        return $subject->getType() === $this->entityType;
    }
}
