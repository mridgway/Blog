<?php

namespace Core\Model;

class Page
{
    /**
     * @var Zend_Layout
     */
    protected $_layout = null;

    /**
     * @var string
     */
    protected $_blockViewName = 'block/wrapper.phtml';

    /**
     * @var Zend_View
     */
    protected $_blockView = null;

    /**
     * @var array
     */
    protected $_containers = array();

    public function __construct($layout = null, $blockWrapper = null)
    {
        $this->setLayout($layout);
        $this->setBlockWrapper($blockWrapper);
    }

    public function addBlock(\Core\Model\AbstractBlock $block, $container = 'content', $weight = null)
    {
        if (null === $weight) {
            $this->_containers[$container][] = $block;
        } else {
            $this->_containers[$container][$weight] = $block;
        }
    }

    public function render($layout = null)
    {
        if (null !== $layout) {
            $this->setLayout($layout);
        }
        foreach ($this->_containers AS $name => $blocks) {
            array_merge($blocks);
            $this->_layout->{$name} = '';
            foreach ($blocks AS $block) {
                $this->getBlockWrapper()->assign('content', $block->render());
                $this->getBlockWrapper()->assign('id', $block->getId());
                $this->getBlockWrapper()->assign('classes', implode(' ', $block->getClasses()));
                $this->_layout->{$name} .= $this->getBlockWrapper()->render($this->_blockViewName);
            }
        }
        return $this->_layout->render($layout);
    }

    public function setLayout($layout = null)
    {
        if (is_string($layout)) {
            $this->_layout->setLayout($layout);
        } else if ($layout instanceof \Zend_Layout) {
            $this->_layout = $layout;
        } else {
            $this->_layout = \Zend_Layout::startMvc();
            $this->_layout->setLayoutPath(APPLICATION_ROOT . "/themes/default/layouts/scripts");
            $this->_layout->disableLayout();
        }

        return $this;
    }

    public function getLayout()
    {
        return $this->_layout;
    }

    public function setBlockWrapper($name)
    {
        if (is_string($name)) {
            $this->_blockViewName = $name;
        }
        return $this;
    }

    public function getBlockWrapper()
    {
        if (null === $this->_blockView) {
            $this->_blockView = new View('Core');
        }
        return $this->_blockView;
    }

    public function __toString()
    {
        return $this->render();
    }
    
}