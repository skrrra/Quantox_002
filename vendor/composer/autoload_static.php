<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4b4c8fd1c2a2f91bf3d594470e0bcaac
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pecee\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pecee\\' => 
        array (
            0 => __DIR__ . '/..' . '/pecee/simple-router/src/Pecee',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4b4c8fd1c2a2f91bf3d594470e0bcaac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4b4c8fd1c2a2f91bf3d594470e0bcaac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4b4c8fd1c2a2f91bf3d594470e0bcaac::$classMap;

        }, null, ClassLoader::class);
    }
}
