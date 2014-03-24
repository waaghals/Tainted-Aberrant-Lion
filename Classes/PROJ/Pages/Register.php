<?php

namespace PROJ\Pages;

class Register extends MainPage {

    /*
     * Do the appropriate action according to the request method
     * Return the view
     */
    public function getContent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $c = new \PROJ\Controllers\RegisterController();
            $valid = $c->validate_input($_POST);
            if($valid === "Registration succeeded!"){
                $account = $c->create_account($_POST);
                $account = $c->create_student($account, $_POST);
            }
            $v = new \PROJ\Views\Register();
                $r = $v->getContent();
                $r .= $v->getErrorContent($valid);
            return $r;
        } else {
            $v = new \PROJ\Views\Register();
            $r = $v->getContent();
            return $r;
        }
    }

}

?>