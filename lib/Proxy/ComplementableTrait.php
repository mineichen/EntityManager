<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.04.14
 * Time: 16:07
 */

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\proxy\NotLoaded;
use mineichen\entityManager\proxy\Complementable;

trait ComplementableTrait {
    public function complement(Complementable $complete)
    {
        if (!($complete instanceof self)) {
            throw new \mineichen\entityManager\Exception(
                sprintf(
                    'Complement needs to be an instance of "%s", "%s" given!',
                    get_class($this),
                    get_class($complete)
                )
            );
        }

        array_walk($this->data, function($value, $key) use ($complete) {
            if ($value instanceof Complementable) {
                $value->complement($complete->get($key));
            } elseif ($this->isComplementable($key)) {
                $this->data[$key] = $complete->get($key);
            }
        });
    }

    public function isComplementable($key)
    {
        return array_key_exists($key, $this->data)
            && $this->data[$key] instanceof NotLoaded;
    }
} 