<?php

namespace mineichen\entityManager\observer\asArray;

use mineichen\entityManager\observer\Generator as GeneratorInterface;
use mineichen\entityManager\observer\GeneratorException as Exception;
use mineichen\entityManager\action\plugin\observer\EntityObserver as EventObserver;

class Generator implements GeneratorInterface
{
    public function getInstanceFor($subject)
    {
        return new EventObserver($subject);
    }
}
