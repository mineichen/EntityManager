<?php

namespace mineichen\entityManager;

class ActionPriorityGeneratorTest extends \PHPUnit_Framework_TestCase 
{
    public function setUp()
    {
         $this->generator = new ActionPriorityGenerator();
    }
    
    public function testWithoutInheritanceContainsAllElements()
    {
        $input = new \SplObjectStorage();
        $input->attach($this->createConfiguredObservable());
        $input->attach($this->createConfiguredObservable());
        
        $list = $this->executeTest($input);
        
        $this->assertEquals(2, $list->count());
    }
    
    public function testWithoutInheritanceHasCorrectOrder()
    {
        $observable1 = $this->createConfiguredObservable();
        $observable2 = $this->createConfiguredObservable();
        
        $input = new \SplObjectStorage();
        $input->attach($observable1);
        $input->attach($observable2);
        
        $list = $this->executeTest($input);
        
        $this->assertSame($list->extract(), $observable1);
        $this->assertSame($list->extract(), $observable2);
    }
    
    public function testWithSimpleInheritance()
    {
        $observable1 = $this->createConfiguredObservable();
        $observable2 = $this->createConfiguredObservable($observable1);
        
        $input = new \SplObjectStorage();
        $input->attach($observable2);
        $input->attach($observable1);
        
        $list = $this->executeTest($input);
        
        $this->assertSame($list->extract(), $observable1);
        $this->assertSame($list->extract(), $observable2);
    }
    
    /**
     * @expectedException mineichen\entityManager\Exception
     */
    public function testWithMultipleInheritance()
    {
        $observable1 = $this->createObservable();
        $observable2 = $this->createConfiguredObservable($observable1);
        $observable3 = $this->createConfiguredObservable($observable2);
        $this->setObservableBehaviour($observable1, array($observable3));
        
        $input = new \SplObjectStorage();
        $input->attach($observable2);
        $input->attach($observable1);
        
        $list = $this->executeTest($input);
        
        $this->assertSame($list->extract(), $observable1);
        $this->assertSame($list->extract(), $observable2);
    }
    
    public function testWorksWellIfObjectWithDependencieIsAttachedFirst()
    {
        $observable1 = $this->createConfiguredObservable();
        $observable2 = $this->createConfiguredObservable($observable1);
        
        $input = new \SplObjectStorage();
        $input->attach($observable1);
        $input->attach($observable2);
        
        $list = $this->executeTest($input);
        
        $this->assertSame($list->extract(), $observable1);
        $this->assertSame($list->extract(), $observable2);
    }
    
    private function executeTest(\SplObjectStorage $storage)
    {
        $this->generator->appendChanges($storage);
        return $this->generator->createQueue();
    }
    
    private function createConfiguredObservable()
    {
        $mock = $this->createObservable();
        $this->setObservableBehaviour($mock, func_get_args());
        return $mock;
    }
    
    private function createObservable()
    {
        return $this->getMock(__NAMESPACE__ . '\\DependencyAware');
    }
    
    private function setObservableBehaviour($observable, array $deps)
    {
       $observable->expects($this->any())
            ->method('getDependencies')
            ->will($this->returnValue($deps)); 
    }
}

