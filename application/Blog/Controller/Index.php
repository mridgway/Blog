<?php

namespace Blog\Controller;

class Index extends \Zend_Controller_Action
{
    public function index()
    {
        echo ('Success: You are in the index controller of the Blog module.');
    }
}