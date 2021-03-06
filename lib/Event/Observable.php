<?php

namespace mineichen\entityManager\event;

interface Observable
{
    public function on($eventType, Callable $callable);
    public function off($eventType, Callable $callable);
}