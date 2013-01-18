<?php

namespace mineichen\entityManager;

use mineichen\entityManager\observer\Observable;
use mineichen\entityManager\observer\Observer;

class BarLoader implements Loader
{
    private $data = array(
        array('firstname' => 'Hans', 'lastname' => 'Muster'),
        array('firstname' => 'Sepp', 'lastname' => 'Träsch')
    );
    
    public function find($id) {
        return $this->loadWithData($this->data[$id]);
    }
    
    public function findBy(array $options)
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
