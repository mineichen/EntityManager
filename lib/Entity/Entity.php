<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event\Observable;
use mineichen\entityManager\proxy\Complementable;

interface Entity extends Observable, Managable, Complementable
{
    public function asArray();
    public function asJson();
}