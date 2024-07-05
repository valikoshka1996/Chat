<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit405e12e44d34a3c74c53021934ba03b2
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit405e12e44d34a3c74c53021934ba03b2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit405e12e44d34a3c74c53021934ba03b2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit405e12e44d34a3c74c53021934ba03b2::$classMap;

        }, null, ClassLoader::class);
    }
}