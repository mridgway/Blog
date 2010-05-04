<?php

namespace Blog\Controller;

class Admin extends \Ridg\Controller\Action
{
    public function addAction()
    {
        $page = new \Core\Model\Page();

        $form = new \Blog\Form\Article();
        $form->setAction('/blog/admin/add/');
        $form->setView(new \Zend_View());

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $article = \Blog\Service\Article::createArticle($data);
                $this->getEntityManager()->persist($article);
                $this->getEntityManager()->flush();
                header('Location: /');
            }
        }

        $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'admin/add.phtml');
        $block->setContent($form);
        $page->addBlock($block);
        
        echo $page->render();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $article = $this->getEntityManager()->getRepository('Blog\Model\Article')->find($id);
        if (null === $article) {
            throw new \Exception('Article invalid.');
        }
        
        $page = new \Core\Model\Page();

        $form = new \Blog\Form\Article();
        $form->setView(new \Zend_View());

        $populate = array(
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'date' => $article->getDate()->format('Y-m-d H:i:s'),
            'published' => $article->getPublished()
        );
        $form->populate($populate);
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                \Blog\Service\Article::updateArticle($article, $data);
                $this->getEntityManager()->flush();
                header('Location: /');
            }
        }

        $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'admin/add.phtml');
        $block->setContent($form);
        $page->addBlock($block);

        echo $page->render();
    }
}