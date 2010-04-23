<?php

namespace Core\Block;

class Standard extends \Core\Model\AbstractBlock
{
    /**
     * @var mixed
     */
    protected $_content;
    
    /**
     * @var string
     */
    protected $_viewName = null;

    protected $_classes = array();

    protected $_id = null;

    public function __construct($view = null, $viewName = null)
    {
        parent::__construct($view);
        $this->setViewName($viewName);
    }

    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    public function appendContent($content)
    {
        if (!is_string($content)) {
            throw new \Exception('Content is not appendable.');
        }
        $this->_content .= (string)$content;
        return $this;
    }

    public function render($viewName = null)
    {
        if (null === $this->_view || null === $this->_viewName) {
            return $this->_content;
        }

        if (null === $viewName) {
            $viewName = $this->_viewName;
        }

        $this->_view->assign('content', $this->_content);
        return $this->_view->render($viewName);
    }
    
    public function setViewName($name)
    {
        $this->_viewName = $name;
        return $this;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function addClass($class)
    {
        $this->_classes[] = $class;
        return $this;
    }

    public function getClasses()
    {
        return $this->_classes;
    }
    
}