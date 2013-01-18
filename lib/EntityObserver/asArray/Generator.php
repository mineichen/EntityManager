<?php

namespace mineichen\entityManager\observer\asArray;

use mineichen\entityManager\observer\Generator as GeneratorInterface;
use mineichen\entityManager\observer\GeneratorException as Exception;

class Generator implements GeneratorInterface
{
    public function getInstanceFor($subject)
    {
        if ($subject instanceof Observable) {
            return new Observer($subject);
        }
        
        throw new Exception(sprintf('No Observer found for "%s"', is_object($subject) ? get_class($subject) : $subject));
    }
}
