<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mineichen\\entitymanager\\bar' => '/data/Bar.php',
                'mineichen\\entitymanager\\barpart' => '/data/BarPart.php',
                'mineichen\\entitymanager\\foo' => '/data/Foo.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd