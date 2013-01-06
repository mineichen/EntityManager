<?php

namespace mineichen\entityManager\entityObserver\asArray;

class GeneratorTest extends \PHPUnit_Framework_TestCase 
{
    private $generator;
    
    public function setUp()
    {
        $this->generator = new Factory;
        
    }
    
    public function testImplementsObservable()
    {
        $this->assertInstanceOf('mineichen\\entityManager\\entityObserver\\Factory', $this->generator);
    }
    
    
    /**
     * @expectedException mineichen\entitymanager\entityobserver\GeneratorException
     */
    public function testThrowExceptionIfObserverIsNotFound()
    {
        $this->generator->getInstanceFor('object');
    }
    
    public function testReturnAsArrayObserver()
    {
        $this->assertInstanceOf(
            __NAMESPACE__ . '\\Observer',
            $this->generator->getInstanceFor(
                $this->getMock(__NAMESPACE__ . '\\Observable')        
            )
        );
    }
}
