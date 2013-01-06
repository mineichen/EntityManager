<?php

namespace mineichen\entityManager;

use mineichen\entityManager\actions\Action;
use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\Saver;
use mineichen\entityManager\actions\Factory as ActionFactory;

class RepositoryRecord 
{
    private $subject;
    private $action;
    private $actionFactory;
    
    public function __construct(Observable $subject, ActionFactory $actionFactory, $actionType)
    {
        $this->subject = $subject;
        $this->actionFactory = $actionFactory;
        $this->setAction($actionType);
    }
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    public function performAction()
    {
        $this->action->performAction();
        $this->setAction($this->action->getActionType());
        
    }
    
    public function isDirty()
    {
        return $this->action->hasNeedForAction();
    }
    
    private function setAction($actionType)
    {
        $this->action = $this->actionFactory->getInstanceFor(
            $this->subject,
            $actionType
        );
    }
}
