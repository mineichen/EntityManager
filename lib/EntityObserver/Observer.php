<?php

namespace mineichen\entityManager\observer;

interface Observer 
{
    public function getSubject();
    public function getDiffs();
    public function hasDiffs();
}