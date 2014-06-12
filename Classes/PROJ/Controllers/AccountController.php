<?php

namespace PROJ\Controllers;

use PROJ\Services\AccountService;
use PROJ\Helper\HeaderHelper;
use PROJ\Tools\Template;

/**
 * Description of AccountController
 *
 * @author Patrick
 * @author Thijs
 */
class AccountController extends BaseController
{

    public function loginAction()
    {
        $accountService = new AccountService();

        $t = new Template("Login");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validCredentials = $accountService->Login($_POST['username'],
                    $_POST['password']);
            $t->error         = $validCredentials;
        }

        $loggedIn = $accountService->isLoggedIn();
        if ($loggedIn) {
            HeaderHelper::redirect("/");
            return;
        }
        echo $t;
    }

    public function logoutAction()
    {
        session_destroy();
        HeaderHelper::redirect();
    }

    public function registerAction()
    {
        $t         = new Template("Register");
        $error     = false;
        $hasErrors = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Form submitted
            $accountService = new AccountService();
            $error          = $accountService->validateInput($_POST);
            $hasErrors      = ($error !== false);

            if (!$hasErrors) {
                $account      = $accountService->createAccount($_POST);
                $accountService->createStudent($account, $_POST);
                $t->error     = "Registration is completed.";
                $t->hasErrors = true;
            }
        }

        $t->error     = $error;
        $t->hasErrors = $hasErrors;
        echo $t;
    }

}
