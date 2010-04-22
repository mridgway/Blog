<?php

namespace Core\Model;

class Page
{
    /**
     * @var Zend_Layout
     */
    public $layout = null;

    /**
     * @var array
     */
    public $containers = array();

    public function __construct($layout)
    {
        if (is_string($layout)) {
            $this->layout = new \Zend_Layout('layout');
        } else if ($layout instanceof \Zend_Layout) {
            $this->layout = $layout;
        } else {
            throw new \Exception('Invalid layout sent to page.');
        }
        
    }

    public function addBlock(\Core\Model\AbstractBlock $block, $container = 'content', $weight = null)
    {
        if (null === $weight) {
            $this->containers[$container][] = $block;
        } else {
            $this->containers[$content][$weight] = $block;
        }
    }

    public function render($layout)
    {
        foreach
    }
    
}