<?php

namespace Core\Block;

class Standard extends \Core\Model\AbstractBlock
{
    /**
     * @var mixed
     */
    protected $_content;

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
        if (null === $this->_view) {
            return $this->_content;
        }

        $this->_view->assign('content', $this->_content);
        return $this->_view->render($viewName);
    }
}