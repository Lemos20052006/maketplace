<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc3e3d15ddd8cd74975bffef2f10f81ca
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitc3e3d15ddd8cd74975bffef2f10f81ca', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc3e3d15ddd8cd74975bffef2f10f81ca', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc3e3d15ddd8cd74975bffef2f10f81ca::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
