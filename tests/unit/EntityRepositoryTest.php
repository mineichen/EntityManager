<?php

namespace mineichen\entityManager\repository;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $loader;
    private $recordManager;
    private $counter;
    private $repository;
    
    public function setUp()
    {
        $this->loader = $this->getMock('mineichen\\entityManager\\Loader');
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
        
        $subject = $this->getMock('mineichen\\entityManager\\entityObserver\\Observable');
        $this->recordManager
            ->expects($this->once())
            ->method('find')
            ->with($id, $this->loader)
            ->will($this->returnValue($subject));
        
        $this->assertSame($subject, $this->repository->find($id));
    }
}
