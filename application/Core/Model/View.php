<?php

namespace Core\Model;

class View extends \Zend_View
{
    
    protected $_module = 'Core';

    public function __construct($config = array())
    {
        if (is_string($config)) {
            $this->_module = ucfirst($config);
            $config = array();
        }
        parent::__construct($config);
        $this->setBasePath(APPLICATION_PATH . '/' . $this->_module . '/View');
    }
}