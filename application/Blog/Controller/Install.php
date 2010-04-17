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
        $this->_tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $this->_classes = array (
            //$em->getClassMetadata('Core\Model\Module')
        );
    }

    public function installAction()
    {
        $this->_tool->createSchema($this->_classes);
    }
}