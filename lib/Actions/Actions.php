<?php

namespace mineichen\entityManager\actions;

interface Action {
    public function performAction();
    public function hasNeedForAction();
    public function commitAfterExecution();
    public function getSubject();
}
