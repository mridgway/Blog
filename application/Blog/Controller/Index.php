<?php

namespace Blog\Controller;

class Index extends \Ridg\Controller\Action
{
    public function indexAction()
    {
        $page = new \Core\Model\Page();

        $articles = $this->getEntityManager()->getRepository('Blog\Model\Article')->findAllPublishedDesc(10, 0);

        if (count($articles)) {
            foreach ($articles AS $article) {
                $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'article/standard.phtml');
                $block->setContent($article);
                $block->addClass('article');
                $page->addBlock($block);
            }
        } else {
            $block = new \Core\Block\Standard();
            $block->setContent('There are no articles to display.');
            $page->addBlock($block);
        }

        echo $page->render();
    }

    public function viewAction()
    {
        die(var_dump($this->getRequest()->getParams()));
        echo 'Coming Soon';
    }

    public function archiveAction()
    {
        echo 'Coming Soon';
    }
}