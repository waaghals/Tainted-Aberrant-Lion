<?php

namespace PROJ\Pages;

class Register extends MainPage {

    public function getContent() {
        $v = new \PROJ\View\Register();
        $r = $v->getContent();

        return $r;
    }
}

?>