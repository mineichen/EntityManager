<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\asArray\Observable;
use mineichen\entityManager\repository\Managable;


class Bar implements Observable, Managable, DependencyAware
{
    use entityObserver\IdTrait;
    
    private $noEntityVar = 'bar';
    private $lastname;
    private $firstname;
    private $dependencies = array();
    private $foo;

    public function __construct($firstname, $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }


    
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }
    
    public function setFoo(Foo $foo) {
        $this->foo = $foo;
        $this->dependencies[] = $foo;
    }
    
    public function asArray()
    {
        $vars = get_object_vars($this);
        unset($vars['noEntityVar']);
        unset($vars['dependencies']);
        
        return $vars;
    }
    
    public function getType()
    {
        return 'Bar';
    }
    
    public function getDependencies() 
    {
        return $this->dependencies;
    }
}