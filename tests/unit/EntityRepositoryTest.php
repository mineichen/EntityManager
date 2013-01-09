<?php

namespace mineichen\entityManager;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $loader;
    private $recordManager;
    private $counter;
    private $repository;
    
    public function setUp()
    {
        $this->loader = $this->getMock(__NAMESPACE__ . '\\Loader');
        $this->recordManager = $this->getMockBuilder(__NAMESPACE__ . '\\RepositorySandbox')->disableOriginalConstructor()->getMock();
        
        $this->repository = new EntityRepository(
            $this->loader,
            $this->recordManager
        );
        
        $this->counter = 0;
    }
    
    public function testFindReturnsExistingEntity()
    {
        $id = 33;
        
        $subject = $this->getMock(__NAMESPACE__ . '\\entityObserver\\Observable');
        $this->recordManager
            ->expects($this->once())
            ->method('fetchSubjectForId')
            ->with($id)
            ->will($this->returnValue($subject));
       
        $this->loader
            ->expects($this->never())
            ->method('load');
        
        $this->assertSame($subject, $this->repository->find($id));
    }
    
    public function testFindLoadsEntityIfNotLoaded()
    {
        $id = 33;
        
        $subject = $this->getMock(__NAMESPACE__ . '\\entityObserver\\Observable');
        $this->recordManager
            ->expects($this->once())
            ->method('fetchSubjectForId')
            ->with($id)
            ->will($this->returnValue(false));
        
        $this->loader
            ->expects($this->once())
            ->method('load')
            ->with($id)
            ->will($this->returnValue($subject));
        
        $this->assertSame($subject, $this->repository->find($id));
    }
}
