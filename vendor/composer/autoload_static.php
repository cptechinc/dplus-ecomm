<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd85ba3772556b7089d92006ffdd59dc2
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dplus\\Ecomm\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dplus\\Ecomm\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Dplus\\Ecomm\\SalesOrdersDisplay' => __DIR__ . '/../..' . '/src/SalesOrdersDisplay.class.php',
        'Family' => __DIR__ . '/../..' . '/src/Model/Family.class.php',
        'ItemGroup' => __DIR__ . '/../..' . '/src/Model/ItemGroup.class.php',
        'ItemMasterItem' => __DIR__ . '/../..' . '/src/Model/ItemMasterItem.class.php',
        'Product' => __DIR__ . '/../..' . '/src/Model/Product.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd85ba3772556b7089d92006ffdd59dc2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd85ba3772556b7089d92006ffdd59dc2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd85ba3772556b7089d92006ffdd59dc2::$classMap;

        }, null, ClassLoader::class);
    }
}
