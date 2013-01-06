<?php

namespace mineichen\entityManager;

interface Loader 
{
    public function load($id);
    public function loadAll();
}
