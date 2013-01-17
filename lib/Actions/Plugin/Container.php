<?php

namespace mineichen\entityManager\action\plugin;

use mineichen\entityManager\repository\Managable;

class Container implements Plugin
{
    public function __construct()
    {
        $this->plugins = new \SplPriorityQueue();
    }

    public function addPlugin(Plugin $plugin, $priority)
    {
        $this->plugins->insert($plugin, $priority);
    }

    public function getPluginFor(Managable $subject)
    {
        foreach($this->plugins as $plugin) {
            $plugin->apply($subject);
        }
    }
}