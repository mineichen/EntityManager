<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 29.04.14
 * Time: 10:46
 */

namespace mineichen\entityManager\repository\Plugin;

use mineichen\entityManager\action\Action;
use mineichen\entityManager\entity\Managable;

abstract class AbstractSaver implements FlushPlugin {
    public function onFlush(Action $action) {
        $this->{$action->getType()}($action->getSubject());
    }

    abstract function create(Managable $subject);
    abstract function update(Managable $subject);
    abstract function delete(Managable $subject);
} 