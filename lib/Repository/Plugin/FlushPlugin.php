<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.04.14
 * Time: 12:57
 */

namespace mineichen\entityManager\repository\Plugin;

use mineichen\entityManager\action\Action;

interface FlushPlugin extends Plugin {
    public function onFlush(Action $action);
    public function afterFlush(Action $action);
} 