<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class LoginAttempt{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string")
     */
    private $time;  

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Account", inversedBy="loginAttempts")
     */
    private $account;
    
    
    public function getTime() {
        return $this->time;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setAccount($account) {
        $this->account = $account;
    }
}

?>
