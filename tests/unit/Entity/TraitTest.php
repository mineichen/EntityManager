<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\Foo;
use mineichen\entityManager\proxy\SimpleNotLoaded;
use mineichen\entityManager\event;

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


    public function testGetOptionalReturnsNull()
    {
        $this->assertNull($this->entity->getOptional());
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

    public function testSetEntityPartInheritsItsEvents()
    {
        $part = new \mineichen\entityManager\BarPart();
        $bar = new \mineichen\entityManager\Bar('firstName', 'lastName');
        $bar->setPart($part);

        $this->assertSame($part, $bar->getPart());

        $observer = $this->getMockBuilder('mineichen\\entityManager\\Bar')
                        ->disableOriginalConstructor()
                        ->getMock();

        $observer->expects($this->once())
            ->method('setId')
            /*->with($this->callback(function(event\Get $e) {
                $this->assertEquals('value', $e->getPrevious()->getKey());
            }))*/;

        $bar->on(event\Event::GET, array($observer, 'setId'));

        $part->getValue();
    }

    /**
     * @depends testSetEntityPartInheritsItsEvents
     */
    public function testSetEntityPartRemovesEventsOnCurrentEntityPart()
    {
        $part = new \mineichen\entityManager\BarPart();
        $newPart = new \mineichen\entityManager\BarPart();

        $bar = new \mineichen\entityManager\Bar('firstName', 'lastName');
        $bar->setPart($part);

        $observer = $this->getMockBuilder('mineichen\\entityManager\\Bar')
            ->disableOriginalConstructor()
            ->getMock();

        $observer->expects($this->never())
            ->method('setId');

        $bar->on(event\Event::GET, array($observer, 'setId'));

        $bar->setPart($newPart);

        $part->getValue();
    }
}