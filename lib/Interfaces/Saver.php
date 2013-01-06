<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entityObserver\Observable;
use mineichen\entityManager\entityObserver\Observer;

interface Saver {
    public function create(Observable $observable);
    public function update(Observer $observer);
    public function remove(Observable $observable);
}
