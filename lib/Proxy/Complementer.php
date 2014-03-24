<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\event;

interface Complementer
{
    public function complement(event\Get $event);
}
