<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Account {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
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

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }
}

?>
