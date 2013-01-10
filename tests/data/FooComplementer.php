<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\Loader;

class FooComplementer implements Complementer
{
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function complement(Complementable $subject)
    {
        $complete = $this->loader->find($subject->getId());
        $subject->setValueToComplement($complete->getValueToComplement());
    }
}
