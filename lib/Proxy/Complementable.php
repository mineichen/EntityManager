<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\repository\Repository;

interface Complementable
{
    public function setComplementer(Complementer $repo);
}
