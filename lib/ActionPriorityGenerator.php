<?php

namespace mineichen\entityManager;

class ActionPriorityGenerator
{
    /**
     * @var \SplObjectStorage
     */
    private $sourceObjectStorage;
    
    /**
     * @var \SplObjectStorage 
     */
    private $tempObjectStorage;
    
    public function __construct()
    {
        $this->sourceObjectStorage = new \SplObjectStorage();
    }
    
    /**
     * @param \SplObjectStorage $objectStorage
     */
    public function appendChanges(\SplObjectStorage $objectStorage)
    {
        $this->sourceObjectStorage->addAll($objectStorage);
    }
    
    /**
     * @return \SplPriorityQueue
     */
    public function createQueue()
    {
        $this->tempObjectStorage = new \SplObjectStorage();
        $this->cacheObjectStorage = new  \SplObjectStorage();
        
        $list = new \SplPriorityQueue();
        
        foreach ($this->sourceObjectStorage as $subject) {
            $list->insert($subject, $this->getPriority($subject) * -1);
        }
        
        return $list;
    }
    
    private function getPriority($subject)
    {
        if ($this->tempObjectStorage->offsetExists($subject)) {
            return $this->tempObjectStorage->offsetGet($subject);
        } 
        
        $prio = $this->calculatePriority($subject);
        $this->tempObjectStorage->attach($subject, $prio);
        return $prio;
    }
    
    private function calculatePriority($subject)
    {
        if ($subject instanceof DependencyAware) {
            return $this->calculatePriorityForDependencyAware($subject);
        }
        
        return 0;
    }
    
    private function calculatePriorityForDependencyAware(DependencyAware $subject) 
    {
        $this->avoidEndlessLoop($subject);
        $range = array(0);
        
        foreach ($subject->getDependencies() as $dependency) {
            $range[] = $this->getPriority($dependency);
        }
        
        return (max($range) + 1);
    }
    
    private function avoidEndlessLoop($subject)
    {
        if ($this->cacheObjectStorage->contains($subject)) {
            throw new Exception('Endless Recursion');
        }
        
        $this->cacheObjectStorage->attach($subject);
    }
}
