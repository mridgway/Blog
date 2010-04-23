<?php

namespace Core\Controller;

class Index extends \Ridg\Controller\Action
{
    public function indexAction()
    {
        $page = new \Core\Model\Page();

        $content = 'Success: You are in the index controller of the Core module.';
        $block = new \Core\Block\Standard($content);
        $page->addBlock($block, 'header', 0);

        echo $page->render();
    }
}