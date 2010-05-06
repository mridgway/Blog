<?php

namespace Core\Form;

class Install extends AbstractForm
{
    public function init()
    {
        $username = new Element\Text('username');
        $username->setLabel('Username');
        $username->setValue('admin');

        $password = new Element\Password('password');
        $password->setLabel('Password');

        $passwordConfirm = new Element\Password('passwordConfirm');
        $passwordConfirm->setLabel('Confirm Password');

        $email = new Element\Text('email');
        $email->setLabel('Email Address');

        $firstName = new Element\Text('firstName');
        $firstName->setLabel('First Name');

        $lastName = new Element\Text('lastName');
        $lastName->setLabel('Last Name');

        $this->addElements(array($username, $password, $passwordConfirm, $email, $firstName, $lastName));

        $this->addDisplayGroup(array('username', 'password', 'passwordConfirm'), 'login');
        $this->getDisplayGroup('login')->setLegend('Login Information');
        $this->addDisplayGroup(array('email', 'firstName', 'lastName'), 'user');
        $this->getDisplayGroup('user')->setLegend('User Information');

        $submit = new Element\Submit('submit');
        $submit->setLabel('Submit');

        $this->addElement($submit);
    }
}