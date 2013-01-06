<?php

namespace mineichen\entityManager;

class ConfigFactory extends ManagerFactory 
{
    /**
     * @var array
     */
    private $config;
    
    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    
    protected function appendRepositories(EntityManager $manager)
    {
        foreach ($this->config as $config) {
            $manager->addRepository(
                $this->getDefaultRepository(
                    $config['entityType'],
                    $config['saver'],
                    $config['loader']
                )
            );
        }
    }
}

