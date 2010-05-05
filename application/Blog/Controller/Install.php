<?php

namespace Blog\Controller;

class Install extends \Ridg\Controller\Action
{

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    protected $_tool;

    /**
     * @var array
     */
    protected $_classes;

    public function init()
    {
        $auth = \Zend_Auth::getInstance();
        if (!$auth->hasIdentity() || !$auth->getIdentity()->isAllowed('blog:install')) {
            header('Location: /login?redir=/blog/install');
            return;
        }
        
        $this->_tool = new \Doctrine\ORM\Tools\SchemaTool($this->getEntityManager());
        $this->_classes = array(
            $this->getEntityManager()->getClassMetadata('Blog\Model\Article')
        );
    }

    public function indexAction()
    {
        $this->_tool->createSchema($this->_classes);
        header('Location: /');
    }
}