<?php

namespace PROJ\Controller;

class RegisterController {

    //put your code here
    public function validate_input($data) {
        if (empty($data['username']) || empty($data['password']) || empty($data['passwordagain'])
                || empty($data['firstname']) || empty($data['surname']) || empty($data['city']) 
                || empty($data['zipcode']) || empty($data['street']) || 
                empty($data['streetnumber'])) {
            return "Not everything is filled in";
        }
        foreach($data as $input){
            if($input == $data['streetnumber'])
                break;
            if(strlen($input) > 254)
                return "Some fieldes are too long.";
            if(!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input))
                return "No special characters allowed" . $input;
        }
        if(!(filter_var($data['streetnumber'], FILTER_VALIDATE_INT)))
                return "Streetnumber is not a number";
        if(!($data['password'] === $data['passwordagain']))
            return "Passwords did not match";
        
        return "Registration succeeded!";
    }
    
    public function create_account($data){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $hashing = new \PROJ\Classes\Hashing();
        $account = new \PROJ\Entities\Account();
        $passwordsalt = split(';', $hashing->create_hash($data['password']));
        $account->setUsername($data['username']);
        $account->setPassword($passwordsalt[0]);
        $account->setSalt($passwordsalt[1]);
        $em->persist($account);
        $em->flush();
        return $account;
    }
    
    public function create_student($account, $data){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $student = new \PROJ\Entities\Student();
        $student->setVoornaam($data['firstname']);
        $student->setAchternaam($data['surname']);
        $student->setPostcode($data['zipcode']);
        $student->setStraat($data['street']);
        $student->setHuisnummer($data['streetnumber']);
        if(isset($data['addition']))
            $student->setToevoeging($data['addition']);
        $student->setWoonplaats($data['city']);
        $student->setAccount($account);
        $em->persist($student);
        $em->flush();
    }
}

?>