<?php

namespace mineichen\entityManager\entityObserver;

interface Observable {
    public function getId();
    public function setId($id);
    public function hasId();
    
    public function getType();
}
