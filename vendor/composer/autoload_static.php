<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1461daba8617519ae933d2672a7738e3
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'PiramideUploader' => __DIR__ . '/../..' . '/piramide-uploader/PiramideUploader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit1461daba8617519ae933d2672a7738e3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1461daba8617519ae933d2672a7738e3::$classMap;

        }, null, ClassLoader::class);
    }
}
