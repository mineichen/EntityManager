<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;

class RepositorySandbox
{
    /**
     * @var \SplObjectStorage
     */
    private $records;
    
    /**
     * @var \mineichen\entityManager\RepositoryRecordGenerator
     */
    private $recordGenerator;
    
    /**
     * @var string
     */
    private $entityType;
    
    /**
     * @param \mineichen\entityManager\RepositoryRecordGenerator $recordGenerator
     * @param string $entityType
     */
    public function __construct(RepositoryRecordGenerator $recordGenerator, $entityType)
    {
        $this->records = new \SplObjectStorage();
        $this->recordGenerator = $recordGenerator;
        $this->entityType = $entityType;
    }
    
    public function getEntityType()
    {
        return $this->entityType;
    }
    
    public function appendChangesTo(ActionPriorityGenerator $generator)
    {
        $generator->appendChanges($this->records);
    }
    
    public function fetchSubjectForId($id)
    {
        $result = $this->getSubjectsForId($id);
        
        switch (count($result)) {
            case 0:
                return false;
            case 1;
                return $result[0];
            default:
                throw new Exception(sprintf('Multiple Records with same ID "%s" registered!', $id));
        }
    }
    
    public function getDirtyRecords()
    {
        return array_map(
            function($subject) {
                return $this->getRecordFor($subject);
            }, 
            $this->getDirtySubjects()
        );
    }
    
    private function getDirtySubjects()
    {  
        return array_filter(
            iterator_to_array($this->records),
            function(Observable $subject) {
                return $this->getRecordFor($subject)->isDirty();
            }
        );
    }
    
    public function isRegistered(Observable $subject)
    {
        return $this->matchesType($subject)
            && $this->hasRecordFor($subject);
    }
    
    public function performAction(Observable $subject)
    {
         $this->getRecordFor($subject)->performAction();
    }
    
    public function attach($subject, $actionType)
    {
        if ($this->hasRecordFor($subject)) {
            return;
        }
        
        $this->attachRecord(
            $this->recordGenerator->create($subject, $actionType)
        );   
    }
    
    /**
     * @param string $id
     * @return array
     */
    private function getSubjectsForId($id)
    {
        return array_filter(
            iterator_to_array($this->records),
            function(Observable $subject) use ($id) {
                return $subject->hasId() && $subject->getId() === $id;
            }
        );
    }
    
    private function attachRecord(RepositoryRecord $record)
    {
        $this->records->attach($record->getSubject(), $record);
    }
    
    private function getRecordFor(Observable $subject)
    {
        return $this->records->offsetGet($subject);
    }
    
    private function hasRecordFor(Observable $subject)
    {
        return $this->records->offsetExists($subject);
    }
    
    private function matchesType(Observable $subject)
    {
        return $subject->getType() === $this->entityType;
    }
}
