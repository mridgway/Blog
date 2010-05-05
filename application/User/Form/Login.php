<?php

namespace User\Form;

class Login extends \Core\Form\AbstractForm
{
    public function init()
    {
        $identity = new \Core\Form\Element\Text('identity');
        $identity->setLabel('Username');
        $identity->setRequired();

        $password = new \Core\Form\Element\Password('password');
        $password->setLabel('Password');

        $submit = new \Core\Form\Element\Submit('submit');
        $submit->setLabel('Login');

        $this->addElements(array($identity, $password, $submit));
    }
}