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
        $manager->flush();
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
    
    
    private function createEntityManager()
    {
        $config = array();
        
        foreach (func_get_args() as $arg) {
            $config[] = array(
                'entityType' => $arg[0],
                'saver' => $arg[1],
                'loader' => $arg[2]
            );
        }
        
        $factory = new ConfigFactory($config);
        return $factory->createManager();
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