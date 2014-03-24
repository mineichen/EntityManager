<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.04.14
 * Time: 12:55
 */

namespace mineichen\entityManager\repository\Plugin;

use mineichen\entityManager\entity\Managable;

interface ManagePlugin extends Plugin {
    public function onAttach(Managable $subject);
    public function onDetach(Managable $subject);
} 