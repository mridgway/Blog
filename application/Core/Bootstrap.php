<?php

/**
 * @todo make autoloader for modules automated
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{
    public function _initModuleAutoloader()
    {
        $autoloader = new \Doctrine\Common\ClassLoader('Core', APPLICATION_PATH);
        $autoloader->register();
    }

    public function _initDispatcher()
    {
        $dispatcher = new \Ridg\Controller\Dispatcher\Standard();
        \Zend_Controller_Front::getInstance()->setDispatcher($dispatcher);
        \Zend_Controller_Front::getInstance()->setModuleControllerDirectoryName('Controller');
    }

    public function _initDoctrine()
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        //$config->setSqlLogger(new \Doctrine\DBAL\Logging\EchoSqlLogger);
        $config->setProxyDir(\APPLICATION_ROOT . \DIRECTORY_SEPARATOR . 'data' . \DIRECTORY_SEPARATOR . 'proxies');
        $config->setProxyNamespace('Proxy');
        $connectionOptions = array(
            'pdo' => $this->getPluginResource('db')->getDbAdapter()->getConnection()
        );
        $evm = new \Doctrine\Common\EventManager();
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config, $evm);

        \Zend_Registry::getInstance()->set('em', $em);

        return $em;
    }
}