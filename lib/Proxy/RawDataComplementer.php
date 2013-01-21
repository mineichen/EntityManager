<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\Loader;
use mineichen\entityManager\event;

class RawDataComplementer implements Complementer
{
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function complement(event\Get $event)
    {
        $subject = $event->getCaller();

        if ($event->getValue() instanceof \mineichen\entityManager\proxy\NotLoaded) {
            $subject->complement(
                $this->loader->find($subject->getId())
            );
        }
    }
}
