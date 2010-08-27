<?php

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application'));
}

if (!defined('APPLICATION_ROOT')) {
    define('APPLICATION_ROOT', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
}

if (!defined('APPLICATION_ENV')) {
    if (getenv('APPLICATION_ENV')) {
        $env = getenv('APPLICATION_ENV');
    } else {
        $env = 'production';
    }
    define('APPLICATION_ENV', $env);
}

if (!defined('LIBRARY_PATH')) {
    define('LIBRARY_PATH', realpath( APPLICATION_ROOT
                                . DIRECTORY_SEPARATOR . 'libraries'));
}

set_include_path( APPLICATION_PATH . PATH_SEPARATOR
                . LIBRARY_PATH . PATH_SEPARATOR
                . get_include_path()
                );

require('ZendX/Application53/Application.php');
$application = new \ZendX\Application53\Application(
    APPLICATION_ENV,
    APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application.ini'
);
$application->bootstrap()->run();
