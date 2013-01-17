<?php

namespace mineichen\entityManager\action\plugin;

use mineichen\entityManager\repository\Managable;

class Collection implements Plugin
{
    private $plugins;

    public function __construct()
    {
        $this->plugins = new \SplPriorityQueue();
    }

    public function addPlugin(Plugin $plugin, $priority)
    {
        $this->plugins->insert($plugin, $priority);
    }

    public function apply(Managable $subject)
    {
        foreach($this->plugins as $plugin) {
            $plugin->apply($subject);
        }
    }
}