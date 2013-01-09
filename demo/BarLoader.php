<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;

class BarLoader implements Loader
{
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
