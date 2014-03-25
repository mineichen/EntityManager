<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mineichen\\entitymanager\\action\\action' => '/Actions/Action.php',
                'mineichen\\entitymanager\\action\\create' => '/Actions/Create.php',
                'mineichen\\entitymanager\\action\\delete' => '/Actions/Delete.php',
                'mineichen\\entitymanager\\action\\factory' => '/Actions/Factory.php',
                'mineichen\\entitymanager\\action\\plugin\\observer\\entityobserver' => '/Observer/EntityObserver.php',
                'mineichen\\entitymanager\\action\\update' => '/Actions/Update.php',
                'mineichen\\entitymanager\\entity\\dependencyaware' => '/Entity/DependencyAware.php',
                'mineichen\\entitymanager\\entity\\entity' => '/Entity/Entity.php',
                'mineichen\\entitymanager\\entity\\entitypart' => '/Entity/EntityPart.php',
                'mineichen\\entitymanager\\entity\\entitytrait' => '/Entity/EntityTrait.php',
                'mineichen\\entitymanager\\entity\\managable' => '/Entity/Managable.php',
                'mineichen\\entitymanager\\entitymanager' => '/EntityManager.php',
                'mineichen\\entitymanager\\event\\datastoretrait' => '/Event/DatastoreTrait.php',
                'mineichen\\entitymanager\\event\\event' => '/Event/Event.php',
                'mineichen\\entitymanager\\event\\get' => '/Event/Get.php',
                'mineichen\\entitymanager\\event\\observable' => '/Event/Observable.php',
                'mineichen\\entitymanager\\event\\observabletrait' => '/Event/ObservableTrait.php',
                'mineichen\\entitymanager\\event\\set' => '/Event/Set.php',
                'mineichen\\entitymanager\\exception' => '/Exception.php',
                'mineichen\\entitymanager\\loader' => '/Repository/Loader.php',
                'mineichen\\entitymanager\\observer\\observer' => '/Observer/Observer.php',
                'mineichen\\entitymanager\\observer\\saverobservertrait' => '/Observer/SaverObserverTrait.php',
                'mineichen\\entitymanager\\proxy\\complementable' => '/Proxy/Complementable.php',
                'mineichen\\entitymanager\\proxy\\complementabletrait' => '/Proxy/ComplementableTrait.php',
                'mineichen\\entitymanager\\proxy\\complementer' => '/Proxy/Complementer.php',
                'mineichen\\entitymanager\\proxy\\traitcomplementer' => '/Proxy/TraitComplementer.php',
                'mineichen\\entitymanager\\repository\\entityrepository' => '/Repository/EntityRepository.php',
                'mineichen\\entitymanager\\repository\\identitymap' => '/Repository/IdentityMap.php',
                'mineichen\\entitymanager\\repository\\plugin\\abstractsaver' => '/Repository/Plugin/AbstractSaver.php',
                'mineichen\\entitymanager\\repository\\plugin\\complementerplugin' => '/Repository/Plugin/ComplementerPlugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\dependencyplugin' => '/Repository/Plugin/DependencyPlugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\extendedflushplugin' => '/Repository/Plugin/ExtendedFlushPlugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\flushplugin' => '/Repository/Plugin/FlushPlugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\manageplugin' => '/Repository/Plugin/ManagePlugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\plugin' => '/Repository/Plugin/Plugin.php',
                'mineichen\\entitymanager\\repository\\plugin\\saver' => '/Repository/Plugin/Saver.php',
                'mineichen\\entitymanager\\repository\\repository' => '/Repository/Repository.php',
                'mineichen\\entitymanager\\repositoryfactory' => '/RepositoryFactory.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd
