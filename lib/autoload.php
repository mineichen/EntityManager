<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mineichen\\entitymanager\\actionprioritygenerator' => '/ActionPriorityGenerator.php',
                'mineichen\\entitymanager\\actions\\action' => '/Actions/Actions.php',
                'mineichen\\entitymanager\\actions\\create' => '/Actions/Create.php',
                'mineichen\\entitymanager\\actions\\delete' => '/Actions/Delete.php',
                'mineichen\\entitymanager\\actions\\factory' => '/Actions/Factory.php',
                'mineichen\\entitymanager\\actions\\update' => '/Actions/Update.php',
                'mineichen\\entitymanager\\configfactory' => '/Factory/ConfigFactory.php',
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
                'mineichen\\entitymanager\\managerfactory' => '/Factory/ManagerFactory.php',
                'mineichen\\entitymanager\\proxy\\complementable' => '/Proxy/Complementable.php',
                'mineichen\\entitymanager\\proxy\\complementer' => '/Proxy/Complementer.php',
                'mineichen\\entitymanager\\proxy\\exception' => '/Proxy/Exception.php',
                'mineichen\\entitymanager\\proxy\\lazyload' => '/Proxy/LazyLoad.php',
                'mineichen\\entitymanager\\proxy\\notloaded' => '/Proxy/NotLoaded.php',
                'mineichen\\entitymanager\\proxy\\simplenotloaded' => '/Proxy/SimpleNotLoaded.php',
                'mineichen\\entitymanager\\repository\\identitymap' => '/Repositories/IdentityMap.php',
                'mineichen\\entitymanager\\repository\\managable' => '/Repositories/Managable.php',
                'mineichen\\entitymanager\\repository\\repository' => '/Repositories/Repository.php',
                'mineichen\\entitymanager\\repository\\repositorysandbox' => '/Repositories/RepositorySandbox.php',
                'mineichen\\entitymanager\\repositoryexception' => '/Repositories/RepositoryException.php',
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