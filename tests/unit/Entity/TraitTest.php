<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\Foo;
use mineichen\entityManager\proxy\SimpleNotLoaded;

class TraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \mineichen\entityManager\Foo
     */
    private $entity;
    public function setUp()
    {
        $this->entity = new Foo('baz', 'bat');
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

    public function testRegisterEntityEvent()
    {
        $this->entity->on('change', array($this, 'changeEventListener'));
    }

    public function changeEventListener($event)
    {
        $this->assertInstanceOf(__NAMESPACE__ . '\\Event\\Set', $event);
    }

    public function testComplementEntity()
    {
        $foo = new Foo('baz', 'bat');
        $foo->setValueToComplement('complemented :)');

        $this->entity->setValueToComplement(new SimpleNotLoaded());
        $this->entity->complement($foo);

        $this->assertEquals(
            $this->entity->getValueToComplement(),
            'complemented :)'
        );
    }

    /**
     * @expectedException \mineichen\entityManager\Exception
     */
    public function testThrowsExceptionIfTryToComplementWithOtherInstanceThenSelf()
    {
        $this->entity->complement(new \mineichen\entityManager\Bar('firstname', 'lastname'));
    }
}