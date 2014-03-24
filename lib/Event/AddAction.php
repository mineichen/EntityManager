<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.03.14
 * Time: 08:25
 */

namespace mineichen\entityManager\event;

use mineichen\entityManager\repository\EntityRepository;

class AddAction implements Event
{
    private $entity;
    private $repo;

    public function __construct(EntityRepository $repo, Entity $entity)
    {
        $this->repo = $repo;
        $this->entity = $entity;
    }
    public function getType()
    {
        return Event::ADD_ACTION;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getRepo()
    {
        return $this->repo;
    }

    public function cloneForCaller(Observable $observable)
    {

    }
} 