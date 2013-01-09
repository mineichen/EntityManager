<?php

namespace mineichen\entityManager;

require_once __DIR__ . '/lib/autoload.php';
require_once __DIR__ . '/demo/Foo.php';
require_once __DIR__ . '/demo/FooSaver.php';
require_once __DIR__ . '/demo/FooLoader.php';
require_once __DIR__ . '/demo/Bar.php';
require_once __DIR__ . '/demo/BarSaver.php';
require_once __DIR__ . '/demo/BarLoader.php';

$factory = new ConfigFactory(array(
    array('entityType' => 'Bar', 'saver' => new BarSaver(), 'loader' => new BarLoader()),
    array('entityType' => 'Foo', 'saver' => new FooSaver(), 'loader' => new FooLoader())
));

$manager = $factory->createManager();

$foo = new Foo('Value1', 'Value2');
$bar = new Bar('Hans', 'Muster');
$bar->setFoo($foo);


$loadedfoo = $manager->find('Foo', 1);
echo 'HasId: ' . (($loadedfoo->hasId()) ? 'Vorhanden' : 'Fehlt!') . PHP_EOL;
var_dump($loadedfoo === $manager->find('Foo', 1));

$loadedfoo->setOptional(''); 


echo '- '.(($manager->isRegistered($bar)) ? 'Registriert' : 'Nicht registriert') . PHP_EOL;
$manager->persist($bar);
echo '- '.(($manager->isRegistered($bar)) ? 'Registriert' : 'Nicht registriert') . PHP_EOL;

//$manager->persist($foo);

echo '- '.(($manager->hasNeedForFlush()) ? 'Changed' : 'Not Changed') . PHP_EOL;
$bar->setFirstName('Mustermann');
echo '- '.(($manager->hasNeedForFlush()) ? 'Changed' : 'Not Changed') . PHP_EOL;

echo PHP_EOL . '-------------------------------------------------------------------------' . PHP_EOL . PHP_EOL;

$manager->flush();

echo PHP_EOL . PHP_EOL . '-------------------------------------------------------------------------' . PHP_EOL . PHP_EOL;

$loadedfoo->setOptional(' ');
echo 'Needs Flush: ' . (($manager->hasNeedForFlush()) ? 'Yes' : 'No');