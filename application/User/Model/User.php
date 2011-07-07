<?php

namespace User\Model;

/**
 * @Entity
 * @Table(name="`User`")
 */
class User extends \Core\Model\AbstractModel implements \Zend_Acl_Role_Interface
{
    /**
     * @var integer
     * @Id @Column(type="integer", name="user_id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", name="email", length="255", nullable="false")
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", name="first_name", length="50", nullable="true")
     */
    protected $firstName;

    /**
     * @var string
     * @Column(type="string", name="last_name", length="50", nullable="true")
     */
    protected $lastName;

    /**
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($email, $firstName = '', $lastName = '')
    {
        $this->setEmail($email);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    /**
     * @return string
     */
    public function getRoleId()
    {
        return 'user';
    }
}