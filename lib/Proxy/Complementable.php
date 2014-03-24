<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 17.04.14
 * Time: 19:27
 */

namespace mineichen\entityManager\proxy;


use mineichen\entityManager\event\Get;

interface Complementable {
    public function isComplementable($key);
    public function complement(array $data);
    public function addFragmentKeys($key1, $key2=null);
} 