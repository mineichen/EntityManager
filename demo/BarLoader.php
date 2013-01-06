<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;

class BarLoader implements Loader
{
    private $repository;
    
    protected function getRepository()
    {
        if (!$this->repository) {
            throw new Exception(sprintf('No repository found in "%s"', get_class($this)));
        }
        
        return $this->repository;
    }
    
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }
    
    private $data = array(
        array('firstname' => 'Hans', 'lastname' => 'Muster'),
        array('firstname' => 'Sepp', 'lastname' => 'Träsch')
    );
    
    public function load($id) {
        return $this->loadWithData($this->data[$id]);
    }
    
    public function loadAll()
    {
        return array_map(
            function($data) {
                return $this->loadWithData($data);
            }, 
            $this->data
        );
    }
    
    private function loadWithData(array $data)
    {
        return new Bar(
            $data['firstname'], 
            $data['lastname']
        );
    }
}
