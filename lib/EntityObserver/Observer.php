<?php

namespace mineichen\entityManager\entityObserver;

interface Observer 
{
    public function getSubject();
    public function getDiffs();
    public function hasDiffs();
}