<?php

namespace PROJ\Controller;

use PROJ\Services\AccountService;
use PROJ\Helper\HeaderHelper;
use PROJ\Tools\Template;

/**
 * Description of AccountController
 *
 * @author Patrick
 */
class AccountController extends BaseController {

    public function loginAction() {
        $l = new \PROJ\View\Login();


        if (isset($_POST['loginBTN'])) {
            //Login button pressed
            $ACCI = AccountServers::instance();
            if ($ACCI->checkLoginCredentials($_POST['username'], $_POST['password']))
                $ACCI->doLogin($_POST['username']);
            else
                $l->setLoginError("Incorrect Credentials");
        }

        //Check for login

        if (isset($_SESSION['user']))
            if ($_SESSION['user']->getId() != null)
                header("Location: /");    //Logged in

                
//Show login screen
        echo $l->getContent();
    }

    public function registerAction() {
        $error = false;
        $hasErrors = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Form submitted
            $c = new AccountService();
            $error = $c->validateInput($_POST);
            $hasErrors = ($error !== true);

            if (!$hasErrors) {
                $account = $c->createAccount($_POST);
                $c->createStudent($account, $_POST);
                HeaderHelper::redirect();
            }
        }
        $t = new Template("Register");
        $t->error = $error;
        $t->hasErrors = $hasErrors;
        echo $t;
    }

}
