<?php

namespace mineichen\entityManager\entityObserver;

interface Factory 
{
    public function getInstanceFor($subject);
}
