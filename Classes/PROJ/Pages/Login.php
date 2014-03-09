<?php

namespace PROJ\Pages;

class Login extends MainPage {
    protected $loginError = null;

    public function getContent() {
        $l = new \PROJ\View\Login();
        
        
        if(isset($_POST['loginBTN'])) {
            //Login button pressed
            $ACCI = \PROJ\Controller\AccountController::instance();
            if($ACCI->checkLoginCredentials($_POST['username'], $_POST['password'])) 
                    $ACCI->doLogin($_POST['username']);
            else
                $l->setLoginError("Incorrect Credentials");
        }
        
        //Check for login
        if(isset($_SESSION['user']))
            if($_SESSION['user']->getId() != null)
                header("Location: /GoogleMap/");    //Logged in
        
        //Show login screen
        $r = $l->getContent();
        
        return $r;
    }
    

}

?>