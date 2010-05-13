<?php
/*
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 */

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
     * @var string
     */
    protected $_pathDelimiter = '\\';

    /**
     * @var array of \Doctrine\Common\Autoloader
     */
    protected $_autoloaders = array();

    /**
     * {@inheritdoc}
     *
     * @param  array $params
     * @return void
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);

    }

    /**
     * Implements Interface
     *
     * {@inheritdoc}
     *
     * @param Zend_Controller_Request_Abstract $action
     * @return boolean
     */
    public function isDispatchable(\Zend_Controller_Request_Abstract $request)
    {
        $className = $this->getControllerClass($request);
        if (!$className) {
            return false;
        }

        try {
            if (!file_exists($this->_getClassPath($className, $this->_autoloaders[$this->_curModule]))) {
                throw new \Exception('File does not exist.');
            }
            $isLoaded = $this->_autoloaders[$this->_curModule]->loadClass($className);
            return $isLoaded;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * A way to get the include file location since Doctrine's classLoader does not currently
     * provide one.
     *
     * @param string $className
     * @param ClassLoader $autoLoader
     * @return string
     */
    protected function _getClassPath($className, \Doctrine\Common\ClassLoader $autoLoader)
    {
        return ($autoLoader->getIncludePath() !== null ? $autoLoader->getIncludePath() . DIRECTORY_SEPARATOR : '')
               . str_replace($autoLoader->getNamespaceSeparator(), DIRECTORY_SEPARATOR, $className)
               . $autoLoader->getFileExtension();
    }

    /**
     * {@inheritdoc}
     *
     * @param string $path
     * @param string $module
     * @return Zend_Controller_Dispatcher_Standard
     */
    public function addControllerDirectory($path, $module = null)
    {
        parent::addControllerDirectory($path, $module);
        if (null === $module) {
            $module = $this->_defaultModule;
        }
        $classLoader = new \Doctrine\Common\ClassLoader($module, realpath($path . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..'));
        $classLoader->register();
        $this->_autoloaders[$module] = $classLoader;
        return $this;
    }

    /**
     * Implements Interface
     *
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

        $module = ucfirst($request->getModuleName());
        if ($this->isValidModule($module)) {
            $this->_curModule    = $module;
        } elseif ($this->isValidModule($this->_defaultModule)) {
            $request->setModuleName($this->_defaultModule);
            $this->_curModule    = $this->_defaultModule;
        } else {
            require_once 'Zend/Controller/Exception.php';
            throw new \Zend_Controller_Exception('No default module defined for this application');
        }
        return $this->_curModule . '\Controller\\' . $className;
    }

    /**
     * Determine if a given module is valid
     *
     * @param  string $module
     * @return bool
     */
    public function isValidModule($module)
    {
        if (!is_string($module)) {
            return false;
        }

        $module        = strtolower($module);
        $controllerDir = $this->getControllerDirectory();
        foreach (array_keys($controllerDir) as $moduleName) {
            if ($module == strtolower($moduleName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Implements Interface
     *
     * {@inheritdoc}
     *
     * @param  string $module Module name
     * @return array|string Returns array of all directories by default, single
     * module directory if module argument provided
     */
    public function getControllerDirectory($module = null)
    {
        return $this->_controllerDirectory;
    }

    /**
     * Format the module name.
     *
     * @param string $unformatted
     * @return string
     */
    public function formatModuleName($unformatted)
    {
        if (($this->_defaultModule == $unformatted) && !$this->getParam('prefixDefaultModule')) {
            return $unformatted;
        }

        return ucfirst($this->_formatName($unformatted));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $unformatted
     * @return string
     */
    public function formatControllerName($unformatted)
    {
        return ucfirst($this->_formatName($unformatted));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $className
     * @return string Class name loaded
     * @throws Zend_Controller_Dispatcher_Exception if class not loaded
     */
    public function loadClass($className)
    {
        return $className;
    }
}