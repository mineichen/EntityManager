<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;

class FooLoader implements Loader
{
    private $data = array(
        1 => array('id' => 1, 'firstname' => 'Hans', 'lastname' => 'Muster'),
        2 => array('id' => 2, 'firstname' => 'Sepp', 'lastname' => 'Träsch')
    );
    
    public function find($id) {
        return $this->loadWithData($this->data[$id]);
    }
    
    public function findBy()
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
        $foo = new Foo(
            $data['firstname'], 
            $data['lastname']
        );
        
        $foo->setId($data['id']);
        
        return $foo;
    }
}
