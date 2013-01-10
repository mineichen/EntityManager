<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\repository\Managable;

interface ObjectRepository {
    public function find($id);
    public function findBy(array $config);
    public function persist(Managable $subject);
    public function flushEntity(Managable $subject);
}
