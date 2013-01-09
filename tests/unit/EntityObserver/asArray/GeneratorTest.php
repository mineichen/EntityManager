<?php

namespace mineichen\entityManager\entityObserver\asArray;

class GeneratorTest extends \PHPUnit_Framework_TestCase 
{
    private $generator;
    
    public function setUp()
    {
        $this->generator = new Generator;
        
    }
    
    public function testImplementsObservable()
    {
        $this->assertInstanceOf('mineichen\\entityManager\\entityObserver\\Generator', $this->generator);
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
            'mineichen\\entityManager\\entityObserver\\Observer',
            $this->generator->getInstanceFor(
                $this->getMock(__NAMESPACE__ . '\\Observable')        
            )
        );
    }
}
