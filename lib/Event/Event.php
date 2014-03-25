<?php

namespace mineichen\entityManager\event;

interface Event
{
    const GET = 'get';
    const SET = 'set';

    public function getType();
    public function cloneForCaller(Observable $caller);
}
