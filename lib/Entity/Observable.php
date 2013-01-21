<?php

namespace mineichen\entityManager\entity;

interface Observable
{
    public function on($eventType, Callable $callable);
    public function off($eventType, Callable $callable);
}