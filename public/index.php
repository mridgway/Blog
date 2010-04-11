<?php
ini_set('display_errors', 1); 
error_reporting(-1);

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
set_include_path( APPLICATION_PATH . PATH_SEPARATOR
                . APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries' . PATH_SEPARATOR
                . get_include_path()
                );

require_once('Doctrine/Common/ClassLoader.php');

$doctrineLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries');
$doctrineLoader->register();

$doctrineLoader = new \Doctrine\Common\ClassLoader('Ridg', APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries');
$doctrineLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('Zend', APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries');
$zendLoader->setNamespaceSeparator('_');
$zendLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('Core', APPLICATION_PATH);
$zendLoader->register();

$application = new \Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'main.ini'
);
$application->bootstrap()->run();
