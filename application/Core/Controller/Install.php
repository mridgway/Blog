<?php

namespace Core\Controller;

class Install extends \Ridg\Controller\Action
{
    public function indexAction()
    {
        header('Location: /user/install/');
    }
}