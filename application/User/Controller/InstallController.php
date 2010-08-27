<?php

namespace User\Controller;

class InstallController extends \ZendX\Application53\Controller\Action
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
        // Skip ACL check if this is first install
        $conn = \Zend_Registry::get('em')->getConnection();
        $stmt = $conn->prepare('SHOW TABLES;');
        $stmt->execute();
        $results = $stmt->fetchAll();
        if (!empty($results)) {
            $auth = \Zend_Auth::getInstance();
            if (!$auth->hasIdentity() || !$auth->getIdentity()->isAllowed('user:install')) {
                throw new \Exception('Not allowed.');
            }
        }

        $this->_tool = new \Doctrine\ORM\Tools\SchemaTool(\Zend_Registry::get('em'));
        $this->_classes = array(
            \Zend_Registry::get('em')->getClassMetadata('User\Model\Identity'),
            \Zend_Registry::get('em')->getClassMetadata('User\Model\User')
        );
    }

    public function indexAction()
    {

        $form = new \Core\Form\Install();
        $form->setView(new \Zend_View());

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $this->_tool->createSchema($this->_classes);
                $this->addAdmin($data);
                if (!\User\Service\User::login($data['username'], $data['password'])) {
                    throw new \Exception('OH GOD WHAT DID YOU DO...');
                }
                header('Location: /blog/install/');
                return;
            }
        }

        $page = new \Core\Model\Page('2col');
        $block = new \Core\Block\Standard(new \Core\Model\View('Core'), 'block/simple.phtml');
        $block->setContent($form);
        $page->addBlock($block, 'content', 0);
        $block = new \Core\Block\Standard();
        $block->setContent('<p style="padding: .5em;">This is the first time this site has been'
                . ' accessed. Please enter your administrator information to install your'
                . ' blog software.</p>');
        $page->addBlock($block, 'sidebar', 0);
        die($page->render());
    }

    private function addAdmin($data)
    {
        $adminUser = new \User\Model\User($data['email'], $data['firstName'], $data['lastName']);
        \Zend_Registry::get('em')->persist($adminUser);

        $adminIdentity = new \User\Model\Identity($adminUser, $data['username']);
        $adminIdentity->setPassword($data['password']);
        \Zend_Registry::get('em')->persist($adminIdentity);

        \Zend_Registry::get('em')->flush();
    }
}