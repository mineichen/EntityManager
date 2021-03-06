<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\Loader;
use mineichen\entityManager\event;

class TraitComplementer implements Complementer
{
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function complement(event\Get $event)
    {
        $subject = $event->getCaller();

        if ($subject->isComplementable($event->getKey())) {
            $subject->complement(
                $this->loader->load($subject->getId())->asArray()
            );
        }
    }
}
