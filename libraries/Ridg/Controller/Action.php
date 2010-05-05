<?php

namespace Ridg\Controller;

class Action extends \Zend_Controller_Action
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_em;

    public function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
    }

    public function getEntityManager() {
        if (null === $this->_em) {
            $this->_em = \Zend_Registry::get('em');
        }
        return $this->_em;
    }
}