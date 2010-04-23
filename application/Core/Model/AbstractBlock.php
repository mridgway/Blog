<?php

namespace Core\Model;

abstract class AbstractBlock
{
    /**
     * @var Zend_View
     */
    protected $_view = null;

    public function __construct($view = null)
    {
        $this->setView($view);
    }

    abstract public function render($viewName = null);

    public function __toString()
    {
        return $this->render($this->_view);
    }

    public function setView($viewName)
    {
        $this->_view = $viewName;
        return $this;
    }
}