<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entity\Entity;

class Bar implements Entity, DependencyAware
{
    use observer\EntityTrait;
    
    private $dependencies = array();

    public function __construct($firstname, $lastname)
    {
        $this->set('firstname', $firstname);
        $this->set('lastname', $lastname);
    }

    public function getType()
    {
        return 'Bar';
    }

    public function setFirstName($firstname)
    {
        $this->set('firstname', $firstname);
    }
    
    public function setFoo(Foo $foo) {
        $this->set('foo', $foo);
        $this->dependencies[] = $foo;
    }

    public function getDependencies() 
    {
        return $this->dependencies;
    }

    public function setPart(BarPart $part)
    {
        $this->set('part', $part);
    }

    public function getPart()
    {
        return $this->get('part');
    }
}