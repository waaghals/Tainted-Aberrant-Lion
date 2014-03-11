<?php

namespace PROJ\Services;

use PROJ\Entities\Student;
use PROJ\Entities\Account;
use PROJ\Tools\Hashing;
use PROJ\Helper\DoctrineHelper;

class AccountService {

    public function checkLoginCredentials($username, $password) {
        $em = DoctrineHelper::instance()->getEntityManager();

        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if ($user != null) {
            //Username exists
            $passwordEntered = hash('sha512', $password . $user->getSalt());

            if ($passwordEntered == $user->getPassword())    //Login correct
                return true;
        }
        return false;
    }

    public function doLogin($username) {
        $em = DoctrineHelper::instance()->getEntityManager();


        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if ($user != null) { //Just to be sure
            $_SESSION['user'] = $user;
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

        return true;
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
        $student->setVoornaam($data['firstname']);
        $student->setAchternaam($data['surname']);
        $student->setPostcode($data['zipcode']);
        $student->setStraat($data['street']);
        $student->setHuisnummer($data['streetnumber']);
        if (isset($data['addition']))
            $student->setToevoeging($data['addition']);
        $student->setWoonplaats($data['city']);
        $student->setAccount($account);
        $em->persist($student);
        $em->flush();
    }

    public static function isLoggedIn() {
        //TODO
    }

}

?>