<?php
/*
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 */

namespace Ridg\Auth\Storage;

class Doctrine extends \Zend_Auth_Storage_Session
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_storedClass = 'User\Model\Identity';

    /**
     * @var User\Model\Identity
     */
    protected $_identity = null;

    /**
     * @param Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct();
        $this->_em = $em;
    }

    /**
     * {@inheritdoc}
     *
     * return mixed
     */
    public function read()
    {
        if (null === $this->_identity) {
            $identityId = parent::read();

            if(null !== $identityId) {
                $this->_identity = $this->getIdentity($identityId);
                if (null !== $this->_identity) {
                    $acl = \Zend_Registry::get('acl');
                    $this->_identity->setAcl($acl);
                } else {
                    $this->clear();
                }
            }
        }

        return $this->_identity;
    }

    /**
     * @param Object $identity
     */
    public function write($identity)
    {
        if (!($identity instanceof $this->_storedClass)) {
            throw new \Exception('Invalid class sent to write command.');
        }

        parent::write($identity->getIdentifier());
        $this->_identity = $identity;
    }

    protected function getIdentity($id)
    {
        return $this->_em->getRepository($this->_storedClass)->find($id);
    }

    public function setStoredClass($className)
    {
        $this->_storedClass = $className;
    }
}