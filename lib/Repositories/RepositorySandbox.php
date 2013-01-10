<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\ActionPriorityGenerator;

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

    public function find($id, $loader) {
        $subject = $this->fetchSubjectForId($id);

        if ($subject === false) {
            $subject = $loader->find($id);
            $this->attach($subject, 'update');
        }

        return $subject;
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
            function(Managable $subject) {
                return $this->getRecordFor($subject)->isDirty();
            }
        );
    }
    
    public function isRegistered(Managable $subject)
    {
        return $this->matchesType($subject)
            && $this->hasRecordFor($subject);
    }
    
    public function performAction(Managable $subject)
    {
         $this->getRecordFor($subject)->performAction();
    }
    
    public function attach(Managable $subject, $actionType)
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
            function(Managable $subject) use ($id) {
                return $subject->hasId() && $subject->getId() === $id;
            }
        );
    }
    
    private function attachRecord(RepositoryRecord $record)
    {
        $this->records->attach($record->getSubject(), $record);
    }
    
    private function getRecordFor(Managable $subject)
    {
        return $this->records->offsetGet($subject);
    }
    
    private function hasRecordFor(Managable $subject)
    {
        return $this->records->offsetExists($subject);
    }
    
    private function matchesType(Managable $subject)
    {
        return $subject->getType() === $this->entityType;
    }
}
