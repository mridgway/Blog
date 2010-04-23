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
        return $this->render();
    }

    public function setView(\Zend_View $view = null)
    {
        if (null === $view) {
            $view = new \Core\Model\View();
        }
        $this->_view = $view;
        return $this;
    }
}