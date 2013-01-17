<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mineichen\\entitymanager\\action\\plugin\\plugin' => '/Actions/Plugin/Plugin.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\complementable' => '/Actions/Plugin/Proxy/Complementable.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\complementer' => '/Actions/Plugin/Proxy/Complementer.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\exception' => '/Actions/Plugin/Proxy/Exception.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\lazyload' => '/Actions/Plugin/Proxy/LazyLoad.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\notloaded' => '/Actions/Plugin/Proxy/NotLoaded.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\plugin' => '/Actions/Plugin/Proxy/Plugin.php',
                'mineichen\\entitymanager\\action\\plugin\\proxy\\simplenotloaded' => '/Actions/Plugin/Proxy/SimpleNotLoaded.php',
                'mineichen\\entitymanager\\actionprioritygenerator' => '/ActionPriorityGenerator.php',
                'mineichen\\entitymanager\\actions\\action' => '/Actions/Actions.php',
                'mineichen\\entitymanager\\actions\\create' => '/Actions/Create.php',
                'mineichen\\entitymanager\\actions\\delete' => '/Actions/Delete.php',
                'mineichen\\entitymanager\\actions\\factory' => '/Actions/Factory.php',
                'mineichen\\entitymanager\\actions\\update' => '/Actions/Update.php',
                'mineichen\\entitymanager\\configfactory' => '/Factory/ConfigManagerFactory.php',
                'mineichen\\entitymanager\\dependencyaware' => '/DependencyAware.php',
                'mineichen\\entitymanager\\entitymanager' => '/EntityManager.php',
                'mineichen\\entitymanager\\entityobserver\\asarray\\generator' => '/EntityObserver/asArray/Generator.php',
                'mineichen\\entitymanager\\entityobserver\\asarray\\observable' => '/EntityObserver/asArray/Observable.php',
                'mineichen\\entitymanager\\entityobserver\\asarray\\observer' => '/EntityObserver/asArray/Observer.php',
                'mineichen\\entitymanager\\entityobserver\\generator' => '/EntityObserver/Generator.php',
                'mineichen\\entitymanager\\entityobserver\\generatorexception' => '/EntityObserver/GeneratorException.php',
                'mineichen\\entitymanager\\entityobserver\\idtrait' => '/Repositories/IdTrait.php',
                'mineichen\\entitymanager\\entityobserver\\observer' => '/EntityObserver/Observer.php',
                'mineichen\\entitymanager\\exception' => '/Exception.php',
                'mineichen\\entitymanager\\loader' => '/Repositories/Loader.php',
                'mineichen\\entitymanager\\repository\\identitymap' => '/Repositories/IdentityMap.php',
                'mineichen\\entitymanager\\repository\\managable' => '/Repositories/Managable.php',
                'mineichen\\entitymanager\\repository\\repository' => '/Repositories/Repository.php',
                'mineichen\\entitymanager\\repository\\repositorysandbox' => '/Repositories/RepositorySandbox.php',
                'mineichen\\entitymanager\\repositoryexception' => '/Repositories/RepositoryException.php',
                'mineichen\\entitymanager\\repositoryfactory' => '/Factory/RepositoryFactory.php',
                'mineichen\\entitymanager\\saver' => '/Repositories/Saver.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd