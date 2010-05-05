<?php

namespace User\Controller;

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
        if (!$this->getRequest()->has('3_141592653')) {
            $auth = \Zend_Auth::getInstance();
            if (!$auth->hasIdentity() || !$auth->getIdentity()->isAllowed('user:install')) {
                throw new \Exception('Not allowed.');
            }
        }
        
        $this->_tool = new \Doctrine\ORM\Tools\SchemaTool($this->getEntityManager());
        $this->_classes = array(
            $this->getEntityManager()->getClassMetadata('User\Model\Identity'),
            $this->getEntityManager()->getClassMetadata('User\Model\User')
        );
    }

    public function indexAction()
    {
        $this->_tool->createSchema($this->_classes);
        $this->addAdmin();

        header('Location: /blog/install/');
    }

    private function addAdmin()
    {
        $adminUser = new \User\Model\User('kokeeno@kokeeno.com', 'Administrator', 'OH YEAH!');
        $this->getEntityManager()->persist($adminUser);

        $adminIdentity = new \User\Model\Identity($adminUser, 'admin');
        $adminIdentity->setPassword('testing');
        $this->getEntityManager()->persist($adminIdentity);

        $this->getEntityManager()->flush();
    }
}