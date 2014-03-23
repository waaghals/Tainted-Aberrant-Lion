<?php

namespace PROJ\Services;

use PROJ\Entities\Student;
use PROJ\Entities\Account;
use PROJ\Tools\Hashing;
use PROJ\Helper\DoctrineHelper;

class AccountService {

    public function Login($username, $password) {
        $em = DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if ($user != null) {
            //Check bruteforce
            if ($this->checkbruteforce($user->getId()) !== true) {
                $passwordEntered = hash('sha512', $password . $user->getSalt());
                if ($passwordEntered == $user->getPassword()) {
                    $_SESSION['user'] = $user;
                    $_SESSION['userID'] = $user->getId();
                    $_SESSION['login_string'] = hash('sha512', $user->getPassword() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                    
                    return true;
                }else{
                    $la = new \PROJ\Entities\LoginAttempt();
                    $la->setTime(time());
                    $la->setAccount($user);
                    
                    $em->persist($la);
                    $em->flush();
                }
            } 
        }
        return false;
    }
    
    private function checkbruteforce($user_id) {
        $now = time();
        $valid_attempts = $now - (2 * 60 * 60); //Entry's laatste 2 uur
        
        
        $em = DoctrineHelper::instance()->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('la')
                ->from('\PROJ\Entities\LoginAttempt', 'la')
                ->where($qb->expr()->gte('la.time', $qb->expr()->literal($valid_attempts)))
                ->andWhere($qb->expr()->eq('la.account', $qb->expr()->literal($user_id)));
       
        //3 login attempts
        if (count($qb->getQuery()->getResult()) > 3) {
            return true;
        } else {
            return false;
        }
    }

    public function validateInput($data) {
        if (empty($data['username']) || empty($data['password']) || empty($data['passwordagain']) || empty($data['firstname']) || empty($data['surname']) || empty($data['city']) || empty($data['zipcode']) || empty($data['street']) ||
                empty($data['streetnumber'])) {
            return "Not everything is filled in";
        }
        foreach ($data as $input) {
            if ($input == $data['streetnumber'])
                break;
            if (strlen($input) > 254)
                return "Some fieldes are too long.";
            if (!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input))
                return "No special characters allowed" . $input;
        }
        if (!(filter_var($data['streetnumber'], FILTER_VALIDATE_INT)))
            return "Streetnumber is not a number";
        if (!($data['password'] === $data['passwordagain']))
            return "Passwords did not match";

        //return "Registration succeeded!";
        return false;
    }

    public function createAccount($data) {
        $em = DoctrineHelper::instance()->getEntityManager();
        $hashing = new Hashing();
        $account = new Account();
        $passwordsalt = split(';', $hashing->createHash($data['password']));
        $account->setUsername($data['username']);
        $account->setPassword($passwordsalt[0]);
        $account->setSalt($passwordsalt[1]);
        $em->persist($account);
        $em->flush();
        return $account;
    }

    public function createStudent($account, $data) {
        $em = DoctrineHelper::instance()->getEntityManager();
        $student = new Student();
        $student->setFirstname($data['firstname']);
        $student->setSurname($data['surname']);
        $student->setZipcode($data['zipcode']);
        $student->setStreet($data['street']);
        $student->setHousenumber($data['streetnumber']);
        if (isset($data['addition']))
            $student->setAddition($data['addition']);
        $student->setCity($data['city']);
        $student->setAccount($account);
        $em->persist($student);
        $em->flush();
    }

    public function isLoggedIn() {
        $em = DoctrineHelper::instance()->getEntityManager();
        if (isset($_SESSION['userID'], $_SESSION['user'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['userID'];
            $login_string = $_SESSION['login_string'];
            
            $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('id' => $user_id));
            if ($user != null) {
                $login_check = hash('sha512', $user->getPassword() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                if ($login_check == $login_string) {
                    return true;
                }
            }
        }
        return false;
    }

}

?>