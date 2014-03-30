<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 01.05.14
 * Time: 15:42
 */

namespace mineichen\entityManager\repository;


use mineichen\entityManager\Foo;

class IdentityMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var mineichen\entityManager\repository\IdentityMap
     */
    private $identityMap;

    public function setUp()
    {
        $this->entity = new Foo('baz', 'bar');
        $this->action = $this->getMock('mineichen\\entityManager\\action\\Action');

        $this->action->expects($this->atLeastOnce())
            ->method('getSubject')
            ->will($this->returnValue($this->entity));

        $this->identityMap = new IdentityMap();
    }

    public function testRemoveAfterAddingId()
    {
        $this->assertFalse($this->entity->hasId());
        $this->identityMap->attach($this->action);
        $this->entity->setId(1);
        $this->identityMap->detach($this->entity);

        $this->assertFalse($this->identityMap->hasActionFor($this->entity));
    }
}
    