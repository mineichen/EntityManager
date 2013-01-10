<?php

namespace mineichen\entityManager\proxy;

interface Complementer
{
    /**
     * Replaces all NotLoaded-Instances inside a Complementable with
     * the real value. If you forget a Value, it will result in a Infinite-Loop,
     * so your Complementer should handle it with an Exception.
     *
     * @throws \mineichen\entityManager\proxy\Exception
     * @param Complementable $subject
     */
    public function complement(Complementable $subject);
}
