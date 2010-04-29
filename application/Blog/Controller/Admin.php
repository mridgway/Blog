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
            
        }

        $block = new \Core\Block\Standard(new \Core\Model\View('Blog'), 'admin/add.phtml');
        $block->setContent($form);
        $page->addBlock($block);
        
        echo $page->render();
    }

    public function editAction()
    {
        echo 'Go Away';
    }
}