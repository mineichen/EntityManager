<?php

namespace mineichen\entityManager;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\observer\Observer;

interface Saver {
    public function create(Managable $observable);
    public function update(Observer $observer);
    public function delete(Observer $observer);
}
