<?php

namespace User\Controller;

class Login extends \Ridg\Controller\Action
{
    protected $_auth;

    public function init()
    {
        $this->_auth = \Zend_Auth::getInstance();
    }

    public function loginAction()
    {
        // @todo make sure we're not already logged in

        $form = new \User\Form\Login();
        $form->setView(new \Zend_View());

        $content = new \stdClass();
        $content->message = '';
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                if (\User\Service\User::login($data['identity'], $data['password'])) {
                    $redir = $this->getRequest()->has('redir') ? $this->getRequest()->getParam('redir') : '/';
                    header('Location: ' . $redir);
                    return;
                } else {
                    $content->message = 'Authentication failed.';
                }
            }
        }

        $page = new \Core\Model\Page();

        $block = new \Core\Block\Standard(new \Core\Model\View('User'), 'login/login.phtml');
        $content->form = $form;
        $block->setContent($content);
        $page->addBlock($block);

        echo $page->render();
    }

    public function logoutAction()
    {
        $this->_auth->clearIdentity();
        header('Location: /');
    }
}
