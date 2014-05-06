<?php

namespace PROJ\Entities;

/**
 * @Entity
 */
class Account
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", unique=true)
     */
    private $username;

    /**
     * @Column(type="string")
     */
    private $password;

    /**
     * @Column(type="string")
     */
    private $salt;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Student", mappedBy="account")
     */
    private $student;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\LoginAttempt", mappedBy="account", cascade={"remove"})
     */
    private $loginAttempts;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getLoginAttempt()
    {
        return $this->loginAttempts;
    }

    public function setStudent($student)
    {
        $this->student = $student;
    }

    public function setLoginAttempt($loginAttempts)
    {
        $this->loginAttempts = $loginAttempst;
    }

    public function jsonSerialize()
    {
        return array(
            "username" => $this->getUsername()
        );
    }

}

?>
