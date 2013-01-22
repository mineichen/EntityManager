<?php

namespace mineichen\entityManager\event;

use mineichen\entityManager\entity\Observable;

interface Event
{
    const GET = 'get';
    const SET = 'set';

    public function getType();
    public function cloneForCaller(Observable $caller);
}
