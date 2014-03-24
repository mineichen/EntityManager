<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.03.14
 * Time: 10:48
 */

namespace mineichen\entityManager\event;


class GetActions implements Event
{
    public function getType()
    {
        return Event::GET_ACTIONS;
    }
} 