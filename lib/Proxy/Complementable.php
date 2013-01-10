<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\repository\ObjectRepository;

interface Complementable
{
    public function setComplementer(Complementer $repo);
}
