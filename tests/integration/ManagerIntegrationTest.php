<?php

namespace mineichen\entityManager;

class ManagerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testFindEntity()
    {
        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $entity = new Bar('', '');
        $entity->setId(10);
        
        $manager = $this->createEntityManager(array('Bar', $saver, $loader));
                
        $loader->expects($this->once())
            ->method('find')
            ->with(10)
            ->will($this->returnValue($entity));
        
        $this->assertSame(
            $entity,
            $manager->find('Bar', 10)
        );
    }
    
    /**
     * @depends testFindEntity
     */
    public function testLoadEntityOnlyOnce()
    {
        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $entity = new Bar('','');
        $entity->setId(10);
        
        $manager = $this->createEntityManager(array('Bar', $saver, $loader));
        
        $loader->expects($this->once())
            ->method('find')
            ->with(10)
            ->will($this->returnValue($entity));
        
        $this->assertSame(
            $entity,
            $manager->find('Bar', 10)
        );
        
        $this->assertSame(
            $entity,
            $manager->find('Bar', 10)
        );
    }
        
    public function testFindWithoutChangeDoesntSaveEntity()
    {
        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $entity = new Bar('','');
        $entity->setId(10);
        
        $manager = $this->createEntityManager(array('Bar', $saver, $loader));
        
        $loader->expects($this->once())
            ->method('find')
            ->with(10)
            ->will($this->returnValue($entity));
        
        $saver
            ->expects($this->never())
            ->method('save');
        
        $manager->find('Bar', 10);
    }
    
    public function testSavesDependencyBeforeSubject()
    {
        $dependency = new Foo('', '');
        $subject = new Bar('', '');
        $subject->setFoo($dependency);
        
        $subloader = $this->mockLoader();
        $deploader = $this->mockLoader();
        $saver = $this->mockSaver();
        
        $manager = $this->createEntityManager(
                array('Bar', $saver, $subloader),
                array('Foo', $saver, $deploader)
        );
        
        $saver
            ->expects($this->at(0))
            ->method('create')
            ->with($this->callback(function($observable) use ($dependency) {
                return $observable === $dependency;
            })
        );
        
        $saver
            ->expects($this->at(1))
            ->method('create')
            ->with($this->callback(function($observable) use ($subject) {
                return $observable === $subject;
            })
        );
        
        $manager->persist($subject);
        $manager->flush();
    }

    public function testProxyEntity()
    {
        $foo = new Foo('baz', 'bat');
        $foo->setId(1234);
        $foo->setValueToComplement($this->getMock('mineichen\entityManager\proxy\NotLoaded'));

        $completeFoo = new Foo('completeBaz', 'completeBat');
        $completeFoo->setId(1234);
        $completeFoo->setValueToComplement('complementValue');


        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $complementer = new proxy\FooComplementer($loader);

        $manager = $this->createEntityManager(
            array('Foo', $saver, $loader, $complementer)
        );

        $loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($foo)));

        $loader->expects($this->once())
            ->method('find')
            ->with(1234)
            ->will($this->returnValue($completeFoo));


        $entity = $manager->findBy('Foo', array())[0];

        $this->assertEquals('complementValue', $entity->getValueToComplement());

        /**
         * Important!
         */
        $this->assertSame($foo, $entity);

        return [$manager, $entity, $loader];
    }

    /**
     * @depends testProxyEntity
     */
    public function testFindByReturnsSameInstanceOnTheSecondTime($params)
    {
        $manager = $params[0];
        $entity = $params[1];
        $loader = $params[2];

        $loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($entity)));

        $this->assertSame($entity, $manager->findBy('Foo', array())[0]);
    }

    public function testEntitysLoadedWithLoadByAreFlushable()
    {
        $foo = new Foo('baz', 'bat');
        $foo->setId(1234);
        $foo->setValueToComplement($this->getMock('mineichen\entityManager\proxy\NotLoaded'));

        $foo2 = new Foo('baz', 'bat');
        $foo2->setId(12345);
        $foo2->setValueToComplement($this->getMock('mineichen\entityManager\proxy\NotLoaded'));

        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $complementer = new proxy\FooComplementer($loader);

        $manager = $this->createEntityManager(
            array('Foo', $saver, $loader, $complementer)
        );

        $loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($foo, $foo2)));


        $saver->expects($this->once())
            ->method('update')
            ->with($this->getObserverForSubjectConstraint($foo));

        $entity = $manager->findBy('Foo', array())[0];

        $this->assertFalse($manager->hasNeedForFlush());
        $entity->setBaz('newValueForTest');
        $this->assertTrue($manager->hasNeedForFlush());

        $manager->flush();
    }

    public function testNewEntityWillBeUpdatedAfterItsFlushedAndThenChanged()
    {
        $foo = new Foo('baz', 'bat');
        $loader = $this->mockLoader();
        $saver = $this->mockSaver();

        $manager = $this->createEntityManager(
            array('Foo', $saver, $loader)
        );

        $saver->expects($this->once())
            ->method('create')
            ->with($foo);

        $manager->persist($foo);
        $manager->flush();

        $saver->expects($this->once())
            ->method('update')
            ->with($this->getObserverForSubjectConstraint($foo));

        $foo->setBat('Something else');

        $manager->flush();
    }

    public function testDeleteEntityIsNotStillInIdentityMapAfterFlush()
    {
        $returnFoo = new Foo('baz', 'bat');
        $returnFoo->setId(10);
        $loader = $this->mockLoader();
        $saver = $this->mockSaver();

        $manager = $this->createEntityManager(
            array('Foo', $saver, $loader)
        );

        $loader->expects($this->exactly(2))
            ->method('find')
            ->with($returnFoo->getId())
            ->will($this->returnValue($returnFoo));

        $saver->expects($this->once())
            ->method('delete')
            ->with($this->getObserverForSubjectConstraint($returnFoo));

        $foo = $manager->find('Foo', 10);
        $manager->delete($foo);
        $manager->flush();


        $manager->find('Foo', 10);
    }

    public function testEntityIsNotDirtyAfterComplementingIt()
    {
        $foo = new Foo('baz', 'bat');
        $foo->setId(10);
        $foo->setValueToComplement(new \mineichen\entityManager\proxy\SimpleNotLoaded());

        $completeFoo = new Foo('baz', 'bat');
        $completeFoo->setId(10);
        $completeFoo->setValueToComplement('Real Value');


        $loader = $this->mockLoader();
        $saver = $this->mockSaver();
        $complementer = new proxy\FooComplementer($loader);

        $loader->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($foo)));

        $loader->expects($this->once())
            ->method('find')
            ->with($foo->getId())
            ->will($this->returnValue($completeFoo));

        $manager = $this->createEntityManager(
            array('Foo', $saver, $loader, $complementer)
        );

        $entity = $manager->findBy('Foo')[0];
        $entity->getValueToComplement();

        $this->assertFalse($manager->hasNeedForFlush());

        return array($manager, $entity);
    }

    /**
     * @depends testEntityIsNotDirtyAfterComplementingIt
     */
    public function testEntityIsDirtyAfterComplementingAndThenChange($props)
    {
        $manager = $props[0];
        $entity = $props[1];

        $entity->setValueToComplement('adsfaslue');

        $this->assertTrue($manager->hasNeedForFlush());
    }

    private function createEntityManager()
    {
        $config = array();
        
        foreach (func_get_args() as $arg) {
            $record = array(
                'entityType' => $arg[0],
                'saver' => $arg[1],
                'loader' => $arg[2]
            );

            if (array_key_exists(3, $arg)) {
                $record['complementer'] = $arg[3];
            }

            $config[] = $record;
        }
        
        $factory = new ConfigFactory($config, new RepositoryFactory());
        return $factory->get();
    }

    private function getObserverForSubjectConstraint($subject)
    {
        return $this->callback(function($observer) use ($subject) {
            return $observer->getSubject() === $subject;
        });
    }

    private function mockComplementer()
    {
        return $this->getMock('mineichen\\entitiyManager\\proxy\\Complementer');
    }
    
    private function mockLoader()
    {
        return $this->getMock('mineichen\\entityManager\\Loader');
    }
    
    private function mockSaver()
    {
        return $this->getMock('mineichen\\entityManager\\Saver');
    }
}