<?php

namespace mineichen\entityManager\actions;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\Saver;
use mineichen\entityManager\repository\IdentityMap;

class Create implements Action
{
    private $identityMap;
    private $subject;
    private $saver;
    
    public function __construct(Managable $subject, Saver $saver, IdentityMap $identityMap)
    {
        $this->subject = $subject;
        $this->saver = $saver;
        $this->identityMap = $identityMap;
    }
    
    public function performAction()
    {
        $this->saver->create($this->subject);
        $this->identityMap->attach($this->subject, 'update');
    }
    
    public function hasNeedForAction()
    {
        return true;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}