<?php

namespace Ridg\Controller\Dispatcher;

class Standard extends \Zend_Controller_Dispatcher_Standard
{
    /**
     * {@inheritdoc}
     * @var string
     */
    protected $_defaultModule = 'Core';

    /**
     * {@inheritdoc}
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return string|false Returns class name on success
     */
    public function getControllerClass(\Zend_Controller_Request_Abstract $request)
    {
        $controllerName = $request->getControllerName();
        if (empty($controllerName)) {
            if (!$this->getParam('useDefaultControllerAlways')) {
                return false;
            }
            $controllerName = $this->getDefaultControllerName();
            $request->setControllerName($controllerName);
        }

        $className = $this->formatControllerName($controllerName);

        $controllerDirs      = $this->getControllerDirectory();
        $module = $this->formatModuleName($request->getModuleName());
        if ($this->isValidModule($module)) {
            $this->_curModule    = $module;
            $this->_curDirectory = $controllerDirs[$module];
        } elseif ($this->isValidModule($this->_defaultModule)) {
            $request->setModuleName($this->_defaultModule);
            $this->_curModule    = $this->_defaultModule;
            $this->_curDirectory = $controllerDirs[$this->_defaultModule];
        } else {
            require_once 'Zend/Controller/Exception.php';
            throw new \Zend_Controller_Exception('No default module defined for this application');
        }

        return $className;
    }
}