<?php

namespace PROJ\Pages;

class DemoPage extends MainPage {

    public function getContent() {
        $v = new \PROJ\Views\DemoView();
        $r = $v->getContent();

        $DC = \PROJ\Controllers\DemoController::instance();
        $r .= $DC->DoDemo();

        return $r;
    }

}

?>