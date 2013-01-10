<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\repository\Managable;
use mineichen\entityManager\ActionPriorityGenerator;

interface Repository {
    public function getEntityType();
    public function persist(Managable $subject);
    public function find($id);
    public function findBy(array $config);
    public function remove(Managable $subject);
    public function flushEntity(Managable $subject);
}
