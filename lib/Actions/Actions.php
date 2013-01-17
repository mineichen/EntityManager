<?php

namespace mineichen\entityManager\action;

interface Action {
    public function performAction();
    public function hasNeedForAction();
    public function getSubject();
}
