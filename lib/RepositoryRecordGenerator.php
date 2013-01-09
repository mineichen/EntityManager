<?php

namespace mineichen\entityManager\repository;
use mineichen\entityManager\actions;
use mineichen\entityManager\entityObserver;

class RepositoryRecordGenerator 
{
    private $actionFactory;
    
    public function __construct(actions\Factory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }
    
    public function create(entityObserver\Observable $subject, $actionType)
    {
        return new RepositoryRecord(
            $subject,
            $this->actionFactory,
            $actionType
        );
    }
}
