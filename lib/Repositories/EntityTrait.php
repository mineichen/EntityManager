<?php

namespace mineichen\entityManager\entityObserver;

trait EntityTrait {
    private $id;
    private $data = array();

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

    protected function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    protected function get($key)
    {
        if (!$this->has($key)) {
            throw new \mineichen\entityManager\Exception(
                sprintf('Value for key "%s" is not set!', $key)
            );
        }

        return $this->data[$key];
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->data);
    }
}