<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class RegistrationCode {

    /**
     * @id @Column(type="string", unique=true)
     */
    private $email;

    /**
     * @Column(type="string")
     */
    private $code;
    
    public function getEmail()
    {
        return $this->email;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }


}