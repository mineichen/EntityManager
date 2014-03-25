<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 29.04.14
 * Time: 10:45
 */

namespace mineichen\entityManager\repository\plugin;

use mineichen\entityManager\action\Action;

interface FlushPlugin extends Plugin {
    public function onFlush(Action $action);
}