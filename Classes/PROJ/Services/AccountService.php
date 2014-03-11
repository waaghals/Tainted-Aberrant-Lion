<?php

namespace PROJ\Services;

class AccountService {

    public function checkLoginCredentials($username, $password) {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

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
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();


        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if ($user != null) { //Just to be sure
            $_SESSION['user'] = $user;
        }
    }

    public static function isLoggedIn() {
        //TODO
    }

}

?>