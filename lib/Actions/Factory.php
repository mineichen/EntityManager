<?php

namespace mineichen\entityManager\action;

use mineichen\entityManager\Exception;
use mineichen\entityManager\repository\EntityRepository;
use mineichen\entityManager\repository\Repository;
use mineichen\entityManager\Saver;
use mineichen\entityManager\observer\Generator as ObserverFactory;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\repository\IdentityMap;
use mineichen\entityManager\proxy\Complementer;

class Factory 
{
    private $actionTypes = [
        'create' => 'mineichen\\entityManager\\action\\Create',
        'update' => 'mineichen\\entityManager\\action\\Update',
        'delete' => 'mineichen\\entityManager\\action\\Delete',
    ];

    public function getInstanceFor(Managable $subject, $type, Repository $repo)
    {
        if(!is_string($type)) {
            var_dump($type); die();
        }
        if (!array_key_exists($type, $this->actionTypes)) {
            throw new Exception(sprintf('Action Type "%s" is not supported', $type));
        }
        $class = $this->actionTypes[$type];

        switch($type) {
            case 'create':
                return new $class($subject, $this->actionTypes['update']);
            default:
                return new $class($subject);
        }
    }
}
