<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\actions\Factory as ActionFactory;

class RepositoryRecord 
{
    private $subject;
    private $action;
    private $actionFactory;
    
    public function __construct(Managable $subject, ActionFactory $actionFactory, $actionType, $identityMap)
    {
        $this->subject = $subject;
        $this->actionFactory = $actionFactory;
        $this->identityMap = $identityMap;
        $this->setAction($actionType);
    }
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    public function performAction()
    {
        $this->action->performAction();
    }

    public function isDirty()
    {
        return $this->action->hasNeedForAction();
    }
    
    private function setAction($actionType)
    {
        $this->action = $this->actionFactory->getInstanceFor(
            $this->subject,
            $actionType,
            $this->identityMap
        );
    }
}
