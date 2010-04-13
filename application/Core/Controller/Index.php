<?php

namespace Core\Controller;

class Index extends \Zend_Controller_Action
{
    public function indexAction()
    {
        echo 'Success: You are in the index controller of the Core module.';
    }
}