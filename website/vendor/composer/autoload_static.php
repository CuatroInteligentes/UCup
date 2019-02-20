<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1bbae46a0c843544fc033b4b5888737a
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TelegramBot\\Api\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TelegramBot\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/telegram-bot/api/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1bbae46a0c843544fc033b4b5888737a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1bbae46a0c843544fc033b4b5888737a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
