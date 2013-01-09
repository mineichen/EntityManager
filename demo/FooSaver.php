<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\entityObserver\Observer;

class FooSaver implements Saver
{
    public function create(Managable $observable)
    {
        echo sprintf('Erstelle "%s"', $observable->getType()) . PHP_EOL;
    }
    
    public function update(Observer $observer)
    {
        echo sprintf('Update "%s"', $observer->getSubject()->getType()) . PHP_EOL;
    }
    
    public function remove(Observer $observer)
    {
        echo sprintf('Lösche "%s"', $observer->getSubject()->getType()) . PHP_EOL;
    }
}
