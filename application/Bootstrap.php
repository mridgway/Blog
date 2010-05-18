<?php

/**
 * @todo make autoloader for modules automated
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{

    public function _initDispatcher()
    {
        $dispatcher = new \Ridg\Controller\Dispatcher\Standard();
        \Zend_Controller_Front::getInstance()->setDispatcher($dispatcher);
        \Zend_Controller_Front::getInstance()->setModuleControllerDirectoryName('Controller');
        return $dispatcher;
    }

    public function _initDoctrine()
    {
        $cache = $this->_getCacheImpl();
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

        \Ridg\Model\AbstractModel::setEntityManager($em);

        return $em;
    }

    public function _initAcl()
    {
        $acl = new \Zend_Acl();
        \Zend_Registry::set('acl', $acl);
        $acl->allow(null, null, 'view');
        $acl->addRole('user');
        return $acl;
    }

    public function _initAuth()
    {
        $auth = \Zend_Auth::getInstance();

        $storage = new \Ridg\Auth\Storage\Doctrine(\Zend_Registry::get('em'));
        $auth->setStorage($storage);
    }

    public function _getCacheImpl()
    {
        $cache = null;
        if(class_exists('Memcache')) {
            $memcache = new \Memcache;
            if (@$memcache->connect('127.0.0.1')) {
                $cache = new \Doctrine\Common\Cache\MemcacheCache();
                $cache->setMemcache($memcache);
                $cache->setNamespace('blog');

                return $cache;
            }
        }

        if (null === $cache && extension_loaded('apc')) {
            $cache = new \Doctrine\Common\Cache\ApcCache();
        } else {
            $cache = new \Doctrine\Common\Cache\ArrayCache();
        }

        $cache->setNamespace('modocms');
        return $cache;
    }
}