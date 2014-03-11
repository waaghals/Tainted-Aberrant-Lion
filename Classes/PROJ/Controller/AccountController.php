<?php

namespace PROJ\Controller;

class AccountController {

    private static $instance;

    /**
     * @return \PROJ\Controller\AccountController
     */
    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function checkLoginCredentials($username, $password) {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if($user != null) {
            //Username exists
            $passwordEntered = hash('sha512', $password . $user->getSalt());
            
            if($passwordEntered == $user->getPassword())    //Login correct
                return true;
        }
        return false;
    }
    
    public function doLogin($username) {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('PROJ\Entities\Account')->findOneBy(array('username' => $username));
        if($user != null) { //Just to be sure
            $_SESSION['user'] = $user;
        }
    }

}

?>