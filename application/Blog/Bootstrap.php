<?php

namespace Blog;

class Bootstrap extends \Zend_Application_Module_Bootstrap
{
    public function _initRoutes() {
        /* @var $router Zend_Controller_Router_Rewrite */
        $router = $this->getApplication()->getResource('FrontController')->getRouter();
        $router->addConfig(new \Zend_Config_Ini(__dir__ . '/routes.ini'));
    }

    public function _initAcl()
    {
        /* @var $acl \Zend_Acl */
        $acl = \Zend_Registry::get('acl');
        $acl->addResource('blog:admin');
        $acl->addResource('blog:install');
    }
}