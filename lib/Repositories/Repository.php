<?php

namespace mineichen\entityManager\repository;

interface ObjectRepository {
    public function find($id);
    public function findBy(array $config);
    public function persist(Managable $subject);
}
