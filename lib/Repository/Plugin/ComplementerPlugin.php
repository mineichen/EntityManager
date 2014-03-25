<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 17.04.14
 * Time: 19:22
 */

namespace mineichen\entityManager\repository\plugin;

use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\proxy\Complementer;
use mineichen\entityManager\proxy\Complementable;

class ComplementerPlugin implements ManagePlugin
{
    private $observed = [];
    private $complementer;

    public function __construct(Complementer $complementer)
    {
        $this->complementer = $complementer;
    }

    public function onAttach(Managable $subject)
    {
        if ($subject instanceof Complementable && $subject->hasId()) {
            $subject->on('get', array($this->complementer, 'complement'));
            $this->observed[] = $subject;
        }
    }

    public function onDetach(Managable $subject)
    {
        if($key = array_search($subject, $this->observed, true) !== false) {
            $subject->off('get', array($this->complementer, 'complement'));
            unset($this->observed[$key]);
        }
    }
} 