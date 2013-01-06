<?php

namespace mineichen\entityManager\entityObserver;

trait IdTrait {
    private $id;
     
    public function hasId()
    {
        return $this->id !== null;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
}