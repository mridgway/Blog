<?php

namespace Core\Block;

class Standard extends \Core\Model\AbstractBlock
{
    /**
     * @var string
     */
    protected $_content;

    public function __construct($content)
    {
        $this->setContent($content);
    }

    public function setContent($content)
    {
        $this->_content = (string)$content;
        return $this;
    }

    public function appendContent($content)
    {
        $this->_content .= (string)$content;
        return $this;
    }

    public function render($view = null)
    {
        return $this->_content;
    }
}