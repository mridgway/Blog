<?php

namespace Blog\Controller;

class Install extends \Ridg\Controller\Action
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

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
        $this->_em = \Zend_Registry::get('em');
        $this->_tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $this->_classes = array (
            $this->_em->getClassMetadata('Blog\Model\Article')
        );
    }

    public function indexAction()
    {
        $this->_tool->dropSchema($this->_classes);
        $this->_tool->createSchema($this->_classes);
    }
}