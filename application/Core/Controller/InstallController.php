<?php

namespace Core\Controller;

class InstallController extends \ZendX\Application53\Controller\Action
{
    public function indexAction()
    {
        header('Location: /user/install/');
    }
}