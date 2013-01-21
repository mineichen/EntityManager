<?php

namespace mineichen\entityManager\entity;

interface Observable
{
    public function on($eventId);
}