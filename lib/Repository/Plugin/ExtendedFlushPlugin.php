<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.04.14
 * Time: 12:57
 */

namespace mineichen\entityManager\repository\plugin;

use mineichen\entityManager\action\Action;

interface ExtendedFlushPlugin extends Plugin {
    public function beforeFlush(Action $action);
    public function afterFlush(Action $action);
} 