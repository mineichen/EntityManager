<?php

namespace mineichen\entityManager\action\plugin;

use mineichen\entityManager\repository\Managable;

interface Plugin
{
    public function apply(Managable $subject);
}