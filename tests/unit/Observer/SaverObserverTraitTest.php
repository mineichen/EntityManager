<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 28.04.14
 * Time: 18:05
 */

namespace mineichen\entityManager\observer;


use mineichen\entityManager\Foo;

class SaverObserverTraitTest extends \PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->entity = new Foo('bar', 'baz');

        $this->saver = $this->getMockForTrait(__NAMESPACE__ . '\\SaverObserverTrait');
    }

    public function testDontExecuteDoUpdateIfSubjectHasNoChanges()
    {
        $this->saver->expects($this->never())
            ->method('doUpdate');

        $this->saver->onAttach($this->entity);
        $this->saver->update($this->entity);
    }

    public function testExecuteJustOnceIfSubjectHasChange()
    {
        $this->saver->expects($this->once())
            ->method('doUpdate')
            ->with($this->entity, ['baz' => 'value']);

        $this->saver->onAttach($this->entity);
        $this->entity->setBaz('value');
        $this->saver->update($this->entity);
        $this->saver->update($this->entity);
    }

    public function testExecuteTwiceOnEventBetween()
    {
        $this->saver->expects($this->exactly(2))
            ->method('doUpdate')
            ->with($this->entity, $this->logicalOr(['baz' => 'value'], ['baz' => 'value2']));

        $this->saver->onAttach($this->entity);
        $this->entity->setBaz('value');
        $this->saver->update($this->entity);
        $this->entity->setBaz('value2');
        $this->saver->update($this->entity);
    }
}
 