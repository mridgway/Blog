<?php

namespace Ridg\Auth\Adapter;

class Identity implements \Zend_Auth_Adapter_Interface
{

    const AUTH_FAIL = 'Authentication Failed';
    const AUTH_SUCCESS = ' Authentication Successful';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_identity = null;

    /**
     * @var string
     */
    protected $_passHash = null;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * @todo fire event on auth failure
     * {@interitdoc}
     *
     * return \Zend_Auth_Result
     */
    public function authenticate()
    {
        $result = $this->_em->getRepository('User\Model\Identity')->findOneByIdentity($this->_identity);

        // Identity not found
        if (null == $result) {
            return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null, array(self::AUTH_FAIL));
        }

        // Identity doesn't require a password, return successful
        if (null === $result->getPassHash()) {
            return new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, $result, array(self::AUTH_SUCCESS));
        }

        // Identity requires password, check it
        if ($this->_passHash != $result->getPassHash()) {
            return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null, array(self::AUTH_FAIL));
        }

        return new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, $result, array(self::AUTH_FAIL));

    }

    /**
     * @param string $identity
     * @return Identity
     */
    public function setIdentity($identity)
    {
        $this->_identity = $identity;
        return $this;
    }

    /**
     * @param string $password
     * @return Identity
     */
    public function setPassword($password)
    {
        $this->setPassHash($this->hash($password));
        return $this;
    }

    /**
     * @param string $passHash
     * @return Identity
     */
    public function setPassHash($passHash)
    {
        $this->_passHash = $passHash;
        return $this;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function hash($value)
    {
        $filter = new \User\Filter\PassHash();
        return $filter->filter($value);
    }
    
}