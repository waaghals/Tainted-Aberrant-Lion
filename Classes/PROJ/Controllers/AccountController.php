<?php

namespace PROJ\Controllers;

use PROJ\Services\AccountService;
use PROJ\Helper\HeaderHelper;
use PROJ\Tools\Template;

/**
 * Description of AccountController
 *
 * @author Patrick
 */
//session_destroy();
class AccountController extends BaseController {

    public function loginAction() {
        $l = new \PROJ\Views\Login();
        $accountService = new AccountService();

        $loggedIn = $accountService->isLoggedIn();
        var_dump($loggedIn);
        if ($loggedIn) {
            HeaderHelper::redirect("/");
            return;
        }

        if (isset($_POST['loginBTN'])) {
            //Login button pressed

            $validCredentials = $accountService->checkLoginCredentials($_POST['username'], $_POST['password']);

            if ($validCredentials) {
                //Remove any broken sessions
                session_destroy();
                $accountService->doLogin($_POST['username']);
                HeaderHelper::redirect("/");
                return;
            } else {
                $l->setLoginError("Incorrect Credentials");
            }
        }

        //Show login screen
        echo $l->getContent();
    }

    public function logoutAction() {
        session_destroy();
        HeaderHelper::redirect();
    }

    public function registerAction() {
        $error = false;
        $hasErrors = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Form submitted
            $accountService = new AccountService();
            $error = $accountService->validateInput($_POST);
            $hasErrors = ($error !== true);
            var_dump($hasErrors);
            if (!$hasErrors) {
                $account = $accountService->createAccount($_POST);
                $accountService->createStudent($account, $_POST);
                HeaderHelper::redirect();
            }
        }
        $t = new Template("Register");
        $t->error = $error;
        $t->hasErrors = $hasErrors;
        echo $t;
    }

}
