<?php

namespace PROJ\Controller;

class RegisterController {

    //put your code here
    public function validate_input() {
        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordagain'])
                || empty($_POST['firstname']) || empty($_POST['surname']) || empty($_POST['city']) 
                || empty($_POST['zipcode']) || empty($_POST['street']) || 
                empty($_POST['streetnumber'])) {
            return "Not everything is filled in";
        }
        foreach($_POST as $input){
            if($input == $_POST['streetnumber'])
                break;
            if(strlen($input) > 254)
                return "Some fieldes are too long.";
        }
        if(!(filter_var($_POST['streetnumber'], FILTER_VALIDATE_INT)))
                return "Streetnumber is not a number";
        if(!($_POST['password'] === $_POST['passwordagain']))
            return "Passwords did not match";
        
        
        return "Registration succeeded!";
    }
    
    public function create_account(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $hashing = new \PROJ\Classes\Hashing();
        $account = new \PROJ\Entities\Account();
        $passwordsalt = split(';', $hashing->create_hash($_POST['password']));
        $account->setUsername($_POST['username']);
        $account->setPassword($passwordsalt[0]);
        $account->setSalt($passwordsalt[1]);
        $em->persist($account);
        $em->flush();
        return $account;
    }
    
    public function create_student($account){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $student = new \PROJ\Entities\Student();
        $student->setVoornaam($_POST['firstname']);
        $student->setAchternaam($_POST['surname']);
        $student->setPostcode($_POST['zipcode']);
        $student->setStraat($_POST['street']);
        $student->setHuisnummer($_POST['streetnumber']);
        if(isset($_POST['addition']))
            $student->setToevoeging($_POST['addition']);
        $student->setWoonplaats($_POST['city']);
        $student->setAccount($account);
        $em->persist($student);
        $em->flush();
    }
}

?>