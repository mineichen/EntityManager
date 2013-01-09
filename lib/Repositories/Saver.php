<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\entityObserver\Observer;

interface Saver {
    public function create(Managable $observable);
    public function update(Observer $observer);
    public function remove(Observer $observer);
}
