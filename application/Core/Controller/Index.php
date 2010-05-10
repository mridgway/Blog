<?php

namespace Core\Controller;

class Index extends \Ridg\Controller\Action
{
    public function indexAction()
    {
        $page = new \Core\Model\Page('1col');

        $content = 'Success: You are in the index controller of the Core module.';
        $block = new \Core\Block\Standard();
        $block->setContent($content);
        $page->addBlock($block, 'content', 0);

        echo $page->render();
    }

    public function aboutAction()
    {
        $page = new \Core\Model\Page('1col');

        $content = 'Coming soon...';
        $block = new \Core\Block\Standard();
        $block->setContent($content);
        $page->addBlock($block, 'content', 0);

        echo $page->render();
    }

    public function contactAction()
    {
        $page = new \Core\Model\Page('1col');

        $content = 'Coming soon...';
        $block = new \Core\Block\Standard();
        $block->setContent($content);
        $page->addBlock($block, 'content', 0);

        echo $page->render();
    }
}