<?php

namespace mineichen\entityManager\repository;

use mineichen\entityManager\entity\Managable;

interface Repository {
    public function getEntityType();
    public function persist(Managable $subject);
    public function find($id);
    public function delete(Managable $subject);
    public function flush();
    public function flushEntity(Managable $subject);
}
