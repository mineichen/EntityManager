<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\Saver;

interface Action {
    public function performAction(Saver $saver);
    public function getSubject();
    public function subjectExistsAfterPerformAction();
}
