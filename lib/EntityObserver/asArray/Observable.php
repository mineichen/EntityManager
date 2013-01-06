<?php

namespace mineichen\entityManager\entityObserver\asArray;

use mineichen\entityManager\entityObserver\Observable as ObservableInterface;

interface Observable extends ObservableInterface
{
    public function asArray();
}
