<?php

namespace User\Service;

class User extends \Core\Service\AbstractService
{
    /**
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public static function login ($username, $password = null)
    {
        $authAdapter = new \Ridg\Auth\Adapter\Identity(self::getEntityManager());
        $authAdapter->setIdentity($username)
                    ->setPassword($password);
        $authResult = $authAdapter->authenticate();
        if ($authResult->isValid()) {
            \Zend_Auth::getInstance()->getStorage()->write($authResult->getIdentity());
            return true;
        }
        return false;
    }
}