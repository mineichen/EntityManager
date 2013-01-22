<?php

namespace mineichen\entityManager\repository;

class RepositorySandboxTest extends \PHPUnit_Framework_TestCase
{
    private $loader;
    private $identityMap;
    private $entityType;
    private $repository;

    public function setUp()
    {
        $this->loader = $this->getMock('mineichen\\entityManager\\Loader');
        $this->identityMap = $this->getMockBuilder(__NAMESPACE__ . '\\IdentityMap')->disableOriginalConstructor()->getMock();
        $this->entityType = 'Test';
        $this->repository = new \mineichen\entityManager\repository\RepositorySandbox(
            $this->identityMap,
            $this->entityType,
            $this->loader
        );
    }

    public function testFindByRegistersEntityAtIdentityMap()
    {
        $subject = $this->getMock('mineichen\\entityManager\\entity\\Managable');

        $this->loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($subject)));

        $this->identityMap
            ->expects($this->once())
            ->method('attach')
            ->with($subject, 'update');

        $this->repository->findBy(array());
    }
}