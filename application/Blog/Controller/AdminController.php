<?php

namespace Blog\Controller;

class AdminController extends \ZendX\Application53\Controller\Action
{
    public function init()
    {
        $auth = \Zend_Auth::getInstance();
        if (!$auth->hasIdentity() || !$auth->getIdentity()->isAllowed('blog:admin')) {
            throw new \Exception('Not allowed.');
        }
    }

    public function addAction()
    {
        $page = new \Core\Model\Page('2col');

        $form = new \Blog\Form\Article\Form();
        $form->removeElement('slug');
        $form->setAction('/blog/admin/add/');
        $form->setView(new \Zend_View());

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $article = \Blog\Service\Article::createArticle($data);
                \Zend_Registry::get('em')->persist($article);
                \Zend_Registry::get('em')->flush();
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
        $article = \Zend_Registry::get('em')->getRepository('Blog\Model\Article')->find($id);
        if (null === $article) {
            throw new \Exception('Article invalid.');
        }
        
        $page = new \Core\Model\Page('2col');

        $form = new \Blog\Form\Article\Form();
        $form->setView(new \Zend_View());

        $mediator = new \Blog\Form\Article\Mediator($form, $article);
        $mediator->populate();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($mediator->isValid($data)) {
                $mediator->transferValues();
                \Zend_Registry::get('em')->flush();
                header('Location: /article/' . $article->getSlug());
            }
        }

        $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'admin/add.phtml');
        $block->setContent($form);
        $page->addBlock($block);

        echo $page->render();
    }
}