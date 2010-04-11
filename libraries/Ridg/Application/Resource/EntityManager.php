<?php

namespace Ridg\Application\Resource;

class EntityManager extends \Zend_Application_Resource_ResourceAbstract
{
    /**
     * Create Entity Manager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function init()
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        //$config->setSqlLogger(new Doctrine\DBAL\Logging\EchoSqlLogger);
        $config->setProxyDir(\APPLICATION_ROOT . \DIRECTORY_SEPARATOR . 'data' . \DIRECTORY_SEPARATOR . 'proxies');
        $config->setProxyNamespace('Proxy');
        $connectionOptions = array(
            'pdo' => $this->getBootstrap()->getPluginResource('db')->getDbAdapter()->getConnection()
        );
        $evm = new \Doctrine\Common\EventManager();
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config, $evm);

        \Zend_Registry::getInstance()->set('em', $em);

        return $em;
    }
}