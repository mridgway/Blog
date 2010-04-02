<?php

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
}

if (!defined('APPLICATION_ROOT')) {
    define('APPLICATION_ROOT', realpath(dirname(__FILE__) . '/..'));
}

if (!defined('APPLICATION_ENV')) {
    if (getenv('APPLICATION_ENV')) {
        $env = getenv('APPLICATION_ENV');
    } else {
        $env = 'production';
    }
    define('APPLICATION_ENV', $env);
}

set_include_path(
    APPLICATION_PATH . PATH_SEPARATOR
    . APPLICATION_ROOT . '/library' . PATH_SEPARATOR
    . get_include_path()
);

require_once('Doctrine/Common/ClassLoader.php');

$doctrineLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_ROOT . '/library');
$doctrineLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('Zend', APPLICATION_ROOT . '/library');
$zendLoader->setNamespaceSeparator('_');
$zendLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('Core', APPLICATION_PATH);
$zendLoader->register();

$application = new \Core\Application();
$application->run();