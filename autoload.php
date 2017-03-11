<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register( 'parserAutoload' );

/**
 * parserAutoload SPL autoloader.
 * @param string $class - The name of the class to load
 */
function parserAutoload($class) 
{
    $prefix = "parser\\";
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
}