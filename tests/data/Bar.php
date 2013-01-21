<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\Managable;


class Bar implements Managable, DependencyAware
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
}