<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;
use mineichen\entityManager\proxy\Complementable;

class FooLoader implements Loader
{
    private $data = array(
        1 => array('id' => 1, 'firstname' => 'Hans', 'lastname' => 'Muster', 'complementValue' => 'It works :)'),
        2 => array('id' => 2, 'firstname' => 'Sepp', 'lastname' => 'Träsch', 'complementValue' => 'It works :)')
    );
    
    public function find($id) {
        echo 'Load complete Entity with ID: ' . $id . PHP_EOL;
        return $this->loadWithData($this->data[$id]);
    }
    
    public function findBy(array $options)
    {
        echo 'Do Load FindBy .......' . PHP_EOL;
        $entities = [];

        foreach($this->data as $data) {
            $foo = $this->loadWithData($data);

            // Simulate incomplete Data
            $foo->setValueToComplement(new \mineichen\entityManager\proxy\SimpleNotLoaded());


            $entities[] =  $foo;
        }
        return $entities;
    }
    
    private function loadWithData(array $data)
    {
        $foo = new Foo(
            $data['firstname'], 
            $data['lastname']
        );
        
        $foo->setId($data['id']);
        $foo->setValueToComplement($data['complementValue']);
        
        return $foo;
    }
}
