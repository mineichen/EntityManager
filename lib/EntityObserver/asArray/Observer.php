<?php

namespace mineichen\entityManager\entityObserver\asArray;

use mineichen\entityManager\entityObserver\Observer as ObserverInterface;

class Observer implements ObserverInterface
{
    private $subject;
    private $pristineData;
    
    public function __construct(Observable $spyable)
    {
        $this->subject = $spyable;
        $this->pristineData = $spyable->asArray();
    }
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    public function getDiffs()
    {
        $current = $this->getSubject()->asArray();
        $diffs = array();
        
        foreach ($this->pristineData as $key => $pristine) {
            if ($current[$key] !== $pristine) {
                $diffs[$key] = $current[$key];
            }
        }
        
        return $diffs;
    }
    
    public function hasDiffs()
    {
        return (bool) $this->getDiffs();
    }
}