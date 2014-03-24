<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 17.04.14
 * Time: 17:54
 */

namespace mineichen\entityManager\repository\Plugin;


use mineichen\entityManager\action\Action;
use mineichen\entityManager\entity\DependencyAware;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\EntityManager;
use mineichen\entityManager\Exception;

class DependencyPlugin implements FlushPlugin
{
    private $manager;
    private $pendingFlush = [];

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function onFlush(Action $action)
    {
        if(in_array($action, $this->pendingFlush, true)) {
            throw new Exception('Infinite loop detected!');
        }

        $this->pendingFlush[] = $action;
        if (($subject = $action->getSubject()) instanceof DependencyAware) {
            if($action->subjectExistsAfterPerformAction()) {
                foreach($subject->getDependencies() as $dep) {
                    if(!$this->manager->contains($dep)) {
                        $this->manager->persist($dep);
                    }
                    $this->manager->flushEntity($dep);
                }
            }
        }
    }

    public function afterFlush(Action $action)
    {
        unset($this->pendingFlush[array_search($action, $this->pendingFlush, true)]);
    }
} 