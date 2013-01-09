<?php

namespace mineichen\entityManager\repository;

interface Managable {
    public function getId();
    public function setId($id);
    public function hasId();

    public function getType();
}
