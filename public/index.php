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

if (!defined('ZEND_PATH')) {
    define('ZEND_PATH', realpath( APPLICATION_ROOT
                                . DIRECTORY_SEPARATOR . 'vendor'
                                . DIRECTORY_SEPARATOR . 'Zend'
                                . DIRECTORY_SEPARATOR . 'library'));
}

if (!defined('ZENDX_PATH')) {
    define('ZENDX_PATH', realpath( APPLICATION_ROOT
                                . DIRECTORY_SEPARATOR . 'vendor'
                                . DIRECTORY_SEPARATOR . 'ZendX'
                                . DIRECTORY_SEPARATOR . 'library'));
}

if (!defined('DOCTRINE_PATH')) {
    define('DOCTRINE_PATH', realpath( APPLICATION_ROOT
                                    . DIRECTORY_SEPARATOR . 'vendor'
                                    . DIRECTORY_SEPARATOR . 'Doctrine2'
                                    . DIRECTORY_SEPARATOR . 'lib'));
}

set_include_path( APPLICATION_PATH . PATH_SEPARATOR
                . APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries' . PATH_SEPARATOR
                . ZEND_PATH . PATH_SEPARATOR
                . DOCTRINE_PATH . PATH_SEPARATOR
                . get_include_path()
                );

require_once('Doctrine/Common/ClassLoader.php');

$doctrineLoader = new \Doctrine\Common\ClassLoader('Doctrine', DOCTRINE_PATH);
$doctrineLoader->register();

$doctrineLoader = new \Doctrine\Common\ClassLoader('Ridg', APPLICATION_ROOT . DIRECTORY_SEPARATOR . 'libraries');
$doctrineLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('Zend', ZEND_PATH);
$zendLoader->setNamespaceSeparator('_');
$zendLoader->register();

$zendLoader = new \Doctrine\Common\ClassLoader('ZendX', ZENDX_PATH);
$zendLoader->setNamespaceSeparator('_');
$zendLoader->register();

$application = new \Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application.ini'
);
$application->bootstrap()->run();
