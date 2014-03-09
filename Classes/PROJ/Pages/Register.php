<?php

namespace PROJ\Pages;

class Register extends MainPage {

    public function getContent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $c = new \PROJ\Controller\RegisterController();
            $valid = $c->validate_input();
            if($valid === "Registration succeeded!"){
                $account = $c->create_account();
                $account = $c->create_student($account);
            }
            $v = new \PROJ\View\Register();
                $r = $v->getContent();
                $r .= $v->getErrorContent($valid);
            return $r;
            
        } else {

            $v = new \PROJ\View\Register();
            $r = $v->getContent();

            return $r;
        }
    }

}

?>