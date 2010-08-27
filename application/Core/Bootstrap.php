<?php

namespace Core;

class Bootstrap extends \Zend_Application_Module_Bootstrap
{
    public function _initRoutes() {
        /* @var $router Zend_Controller_Router_Rewrite */
        $router = $this->getApplication()->getResource('FrontController')->getRouter();
        $router->addConfig(new \Zend_Config_Ini(__dir__ . '/routes.ini'));
    }
}