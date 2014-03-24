<?php

namespace mineichen\entityManager\entity;

interface DependencyAware 
{
    public function getDependencies();
}
