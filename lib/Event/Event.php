<?php

namespace mineichen\entityManager\event;

interface Event
{
    const GET = 'get';
    const SET = 'set';
    const ADD_ACTION = 'addAction';
    const GET_ACTIONS = 'getActions';

    public function getType();
    public function cloneForCaller(Observable $caller);
}
