<?php

namespace mineichen\entityManager;

class ConfigFactory
{
    /**
     * @var array
     */
    private $config;

    private $repoFactory;

    /**
     * @param array $config
     */
    public function __construct(array $config, RepositoryFactory $repoFactory)
    {
        $this->config = $config;
        $this->repoFactory = $repoFactory;
    }

    public function get()
    {
        $manager = new EntityManager();
        $this->appendRepositories($manager);
        return $manager;
    }
    
    protected function appendRepositories(EntityManager $manager)
    {
        foreach ($this->config as $config) {
            $repo = $this->repoFactory->get(
                $config['entityType'],
                $config['saver'],
                $config['loader'],
                (array_key_exists('complementer', $config) ? $config['complementer'] : null)
            );

            $manager->addRepository($repo);
        }
    }
}

