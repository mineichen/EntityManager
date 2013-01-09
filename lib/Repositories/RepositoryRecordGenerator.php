<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\actions;

class RepositoryRecordGenerator 
{
    private $actionFactory;
    
    public function __construct(actions\Factory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }
    
    public function create(Managable $subject, $actionType)
    {
        return new RepositoryRecord(
            $subject,
            $this->actionFactory,
            $actionType
        );
    }
}
