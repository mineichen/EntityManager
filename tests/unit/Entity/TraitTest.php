<?php

namespace mineichen\entityManager\entity;

class TraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \mineichen\entityManager\Foo
     */
    private $entity;
    public function setUp()
    {
        $this->entity = new \mineichen\entityManager\Foo('baz', 'bat');
    }

    public function testHasReturnsFalseOnOptionalValue()
    {
        $this->assertFalse($this->entity->hasOptional());
    }

    public function testGetReturnsValueIfValueIsSet()
    {
        $this->assertEquals('baz', $this->entity->getBaz());
    }

    /**
     * @expectedException \mineichen\entityManager\Exception
     */
    public function testGetOptionalThrowsException()
    {
        $this->entity->getOptional();
    }
}