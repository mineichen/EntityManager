<?php
/**
 * Created by PhpStorm.
 * User: mineichen
 * Date: 27.03.14
 * Time: 11:15
 */

namespace mineichen\entityManager\event;

trait DatastoreTrait {
    use ObservableTrait { trigger as private; }

    private $data = array();

    protected function set($key, $value)
    {
        $this->trigger(
            new Set($this, $key, $this->has($key) ? $this->data[$key] : null, $value)
        );

        $this->data[$key] = $value;
    }

    public function get($key)
    {
        $this->trigger(
            new Get($this, $key, $this->has($key) ? $this->data[$key] : null)
        );

        return $this->has($key) ? $this->data[$key] : null;
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function redirectEvent(Event $event)
    {
        $this->trigger(
            $event->cloneForCaller($this)
        );
    }
} 