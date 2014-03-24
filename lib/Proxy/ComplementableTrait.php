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
    private $fragmentKeys = [];

    public function addFragmentKeys($key1, $key2 = null)
    {
        $this->fragmentKeys = array_flip(func_get_args() + $this->fragmentKeys);
    }

    public function getFragmentKeys()
    {
        return $this->fragmentKeys;
    }

    public function complement(array $data)
    {
        array_walk($data, function($value, $key) {
            if ($this->has($key) && $this->data[$key] instanceof Complementable) {
                $this->data[$key]->complement($value);
            } elseif ($this->isComplementable($key)) {
                $this->data[$key] = $value;
            }
        });
    }

    public function isComplementable($key)
    {
        return array_key_exists($key, $this->fragmentKeys);
    }
} 