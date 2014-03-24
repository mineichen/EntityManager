<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 28.04.14
 * Time: 17:33
 */

namespace mineichen\entityManager\observer;


use mineichen\entityManager\action\plugin\observer\EntityObserver;
use mineichen\entityManager\entity\Managable;
use mineichen\entityManager\event\Observable;

trait SaverObserverTrait {
    private $observers;
    public function update(Managable $managable) {
        $observer = $this->observers[$managable];
        if($observer->hasDiffs()) {
            $this->doUpdate($managable, $observer->getDiffs());
        }
    }

    public function onAttach(Managable $subject)
    {
        $this->getObservers()->attach(
            $subject,
            $this->createObserverFor($subject)
        );
    }

    public function onDetach(Managable $subject)
    {
        $this->getObservers()->detach($subject);
    }

    protected function createObserverFor(Observable $observable)
    {
        return new EntityObserver($observable);
    }

    private function getObservers()
    {
        if(!$this->observers) {
            $this->observers = new \SplObjectStorage();
        }
        return $this->observers;
    }

    public abstract function doUpdate(Managable $subject, array $changes);
} 