<?php

namespace mineichen\entityManager\action;

interface Action {
    public function getType();
    public function getSubject();
    public function subjectExistsAfterPerformAction();
    public function getNextAction();
}
