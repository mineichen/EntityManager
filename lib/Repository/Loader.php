<?php

namespace mineichen\entityManager;

interface Loader 
{
    public function find($id);
    public function findBy(array $options);
}
