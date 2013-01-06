<?php

namespace mineichen\entityManager;

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
