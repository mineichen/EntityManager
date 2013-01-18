<?php

namespace mineichen\entityManager\observer\asArray;

class ObserverTest extends \PHPUnit_Framework_TestCase 
{
    private $entity;
    private $observer;
    
    public function setUp()
    {
        $this->entity = $this->getMock(__NAMESPACE__ . '\\Observable');
        
    }
    
    public function testImplementsObservable()
    {
        $this->assertInstanceOf('mineichen\\entityManager\\observer\\Observer', $this->getObserver());
    }
    
    public function testGetPristineDataReturnsEmptyArray()
    {
        $conf = ['foo' => 'bar'];
        
        $this->assertSame(
            array(),
            $this->init($conf, $conf)->getDiffs()
        );
    }    
    
    public function testGetDiffsReturnsDiffs()
    {
        $this->assertSame(
            ['bar' => 'baz'],
            $this->init(['bar' => 'foo'], ['bar' => 'baz'])->getDiffs()
        );
    }
    
    public function testHasPristineDataReturnsFalse()
    {
        $conf = ['foo' => 'bar'];
        
        $this->assertFalse(
            $this->init($conf, $conf)->hasDiffs()
        );
    }
    
    
    private function init($first, $second)
    {
        $this->entity
            ->expects($this->at(0))
            ->method('asArray')
            ->will($this->returnValue($first));
        
        $this->entity
            ->expects($this->at(1))
            ->method('asArray')
            ->will($this->returnValue($second));
        
        return $this->getObserver();
    }
    
    private function getObserver()
    {
        return new Observer($this->entity);
    }
}
