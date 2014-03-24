<?php

namespace mineichen\entityManager\repository;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $loader;
    private $identityMap;
    private $entityType;
    private $repository;

    public function setUp()
    {
        $this->actionFactory = $this->getMockBuilder('mineichen\\entityManager\\action\\Factory')->disableOriginalConstructor()->getMock();
        $this->loader = $this->getMock('mineichen\\entityManager\\Loader');
        $this->saver = $this->getMock('mineichen\\entityManager\\Saver');
        $this->identityMap = $this->getMockBuilder(__NAMESPACE__ . '\\IdentityMap')->disableOriginalConstructor()->getMock();
        $this->entityType = 'Test';
        $this->repository = new EntityRepository(
            $this->identityMap,
            $this->entityType,
            $this->loader,
            $this->saver,
            $this->actionFactory
        );
    }

    public function testFindByRegistersEntityAtIdentityMap()
    {
        $subject = $this->getMock('mineichen\\entityManager\\entity\\Managable');
        $action = $this->getMock('mineichen\\entityManager\\action\\Action');

        $subject->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($this->entityType));

        $this->loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($subject)));

        $this->actionFactory
            ->expects($this->once())
            ->method('getInstanceFor')
            ->will($this->returnValue($action));

        $this->identityMap
            ->expects($this->once())
            ->method('attach')
            ->with($this->isInstanceOf('mineichen\\entityManager\\action\\Action'));

        $this->identityMap
            ->expects($this->atLeastOnce())
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayIterator([])));

        $this->repository->findBy(array());
    }
}