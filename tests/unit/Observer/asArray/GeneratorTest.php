<?php

namespace mineichen\entityManager\observer\asArray;

class GeneratorTest extends \PHPUnit_Framework_TestCase 
{
    private $generator;
    
    public function setUp()
    {
        $this->generator = new Generator;
        
    }
    
    public function testImplementsObservable()
    {
        $this->assertInstanceOf('mineichen\\entityManager\\observer\\Generator', $this->generator);
    }
    
    
    /**
     * @expectedException mineichen\entitymanager\observer\GeneratorException
     */
    public function testThrowExceptionIfObserverIsNotFound()
    {
        $this->generator->getInstanceFor('object');
    }
    
    public function testReturnAsArrayObserver()
    {
        $this->assertInstanceOf(
            'mineichen\\entityManager\\observer\\Observer',
            $this->generator->getInstanceFor(
                $this->getMock(__NAMESPACE__ . '\\Observable')        
            )
        );
    }
}
