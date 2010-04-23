<?php

namespace Core\Model;

abstract class AbstractBlock
{
    /**
     * @var Zend_View
     */
    protected $_view;

    abstract public function render($view);

    public function __toString()
    {
        return $this->render($this->_view);
    }

    public function setView(\Zend_View $view)
    {
        $this->_view = $view;
        return $this;
    }
}