<?php

namespace mineichen\entityManager;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\observer\Observer;
use mineichen\entityManager\repository\Plugin\Plugin;

interface Saver extends Plugin {
    public function create(Managable $subject);
    public function update(Managable $subject);
    public function delete(Managable $subject);
}
