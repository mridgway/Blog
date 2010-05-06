<?php

namespace Blog\Controller;

class Index extends \Ridg\Controller\Action
{
    public function indexAction()
    {
        $page = new \Core\Model\Page();

        $publishedArticles = $this->getEntityManager()->getRepository('Blog\Model\Article')->findAllPublishedDesc(10, 0);

        if (count($publishedArticles)) {
            foreach ($publishedArticles AS $article) {
                $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'article/short.phtml');
                $block->setContent($article);
                $block->addClass('article');
                $page->addBlock($block);
            }
        } else {
            $block = new \Core\Block\Standard();
            $block->setContent('There are no articles to display.');
            $page->addBlock($block);
        }

        if (\Zend_Auth::getInstance()->hasIdentity()) {
            
            $block = new \Core\Block\Standard();
            $block->setContent('<p><a href="/blog/admin/add/">Add New Article</a></p>');
            $page->addBlock($block, 'sidebar');

            $unpublishedArticles = $this->getEntityManager()->getRepository('Blog\Model\Article')->findAllUnpublishedDesc(10, 0);

            $block = new \Core\Block\Standard();
            $block->setContent('<h3>Unpublished Articles</h3>');
            $page->addBlock($block, 'sidebar');
            if (count($unpublishedArticles)) {
                foreach ($unpublishedArticles AS $article) {
                    $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'article/titleLink.phtml');
                    $block->setContent($article);
                    $page->addBlock($block, 'sidebar');
                }
            } else {
                $block = new \Core\Block\Standard();
                $block->setContent('There are no unpublished articles.');
                $page->addBlock($block, 'sidebar');
            }
        }

        echo $page->render();
    }

    public function viewAction()
    {


        $slug = $this->getRequest()->getParam('slug');
        if (null === $slug) {
            throw new \Exception('Article not found.');
        }

        $article = $this->getEntityManager()->getRepository('Blog\Model\Article')->findOneBySlug($slug);
        if (null === $article) {
            throw new \Exception('Article not found.');
        }

        if (!$article->getPublished() && !\Zend_Auth::getInstance()->hasIdentity()) {
            throw new \Exception('Article not found.');
        }
        
        $page = new \Core\Model\Page();
        
        $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'article/standard.phtml');
        $block->setContent($article);
        $block->addClass('article');
        $page->addBlock($block);

        echo $page->render();
    }

    public function archiveAction()
    {
        echo 'Coming Soon';
    }
}