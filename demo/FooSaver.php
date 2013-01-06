<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;

class FooSaver implements Saver
{
    public function create(Observable $observable)
    {
        echo sprintf('Erstelle "%s"', $observable->getType()) . PHP_EOL;
    }
    
    public function update(Observer $observer)
    {
        echo sprintf('Update "%s"', $observer->getSubject()->getType()) . PHP_EOL;
    }
    
    public function remove(Observable $observable)
    {
        echo sprintf('Lösche "%s"', $observer->getSubject()->getType()) . PHP_EOL;
    }
}
