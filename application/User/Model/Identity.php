<?php

namespace User\Model;

/**
 * @Entity
 */
class Identity extends \Core\Model\AbstractModel implements \Zend_Acl_Role_Interface
{
    
    /**
     * @var integer
     * @Id @Column(type="string", name="identity", length="255", nullable="false", unique="true")
     */
    protected $identity;

    /**
     * @var string
     * @Column(type="string", name="pass_hash", length="128", nullable="true")
     */
    protected $passHash;

    /**
     * @var User
     * @ManyToOne(targetEntity="User\Model\User", fetch="EAGER")
     * @JoinColumn(name="user_id", referencedColumnName="user_id", nullable="false")
     */
    protected $user;

    /**
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * @param User $user
     * @param string $identity
     * @param string $passHash
     */
    public function __construct(User $user, $identity, $passHash = null)
    {
        $this->setUser($user);
        $this->setIdentity($identity);
        $this->setPassHash($passHash);
    }

    /**
     * @param User $user
     * @return Identity
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $passHash
     * @return PassHash
     */
    public function setPassHash($passHash = null)
    {
        $this->passHash = $passHash;
        return $this;
    }

    /**
     * @param string $password
     * @return PassHash
     */
    public function setPassword($password = null)
    {
        if (null !== $password) {
            $password = $this->hash($password);
        }
        $this->setPassHash($password);
        return $this;
    }

    /**
     * @param string $value
     * @return string hashed value
     */
    protected function hash($value)
    {
        $filter = new \User\Filter\PassHash();
        return $filter->filter($value);
    }

    /**
     * @todo make this function part of an indentifiable interface
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getIdentity();
    }

    /**
     * @return string
     */
    public function getRoleId()
    {
        return 'user';
    }

    /**
     * @param string|Zend_Acl_Role_Interface $resource
     * @param string $action
     * @return boolean
     */
    public function isAllowed($resource = null, $action = null)
    {
        return $this->_acl->isAllowed($this, $resource, $action);
    }

    /**
     * @param Zend_Acl $acl
     * @return Identity
     */
    public function setAcl(\Zend_Acl $acl)
    {
        $this->_acl = $acl;
        return $this;
    }

    /**
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->_acl;
    }

}