<?php

namespace mineichen\entityManager\entity;

interface Managable {
    public function getId();
    public function setId($id);
    public function hasId();
    public function getType();
}
