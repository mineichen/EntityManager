<?php

namespace mineichen\entityManager\entityObserver\asArray;

use mineichen\entityManager\entityObserver\Factory as GeneratorInterface;
use mineichen\entityManager\entityObserver\GeneratorException as Exception;

class Factory implements GeneratorInterface
{
    public function getInstanceFor($subject)
    {
        if ($subject instanceof Observable) {
            return new Observer($subject);
        }
        
        throw new Exception(sprintf('No Observer found for "%s"', is_object($subject) ? get_class($subject) : $subject));
    }
}
