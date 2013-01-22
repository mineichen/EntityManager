<?php

namespace mineichen\entityManager\entity;

use mineichen\entityManager\event;
use mineichen\entityManager\proxy\NotLoaded;
use mineichen\entityManager\entity\Managable;

trait EntityTrait {
    private $id;
    use \mineichen\entityManager\entity\ObservableTrait;

    public function hasId()
    {
        return $this->id !== null;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function complement(Managable $complete)
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
            if ($value instanceof Managable) {
                $value->complement($complete->get($key));
            } elseif ($value instanceof NotLoaded) {
                $this->data[$key] = $complete->get($key);
            }
        });
    }
}