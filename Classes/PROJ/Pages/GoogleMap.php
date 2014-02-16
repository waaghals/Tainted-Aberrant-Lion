<?php

namespace PROJ\Pages;

class GoogleMap extends MainPage {

    public function getContent() {
        $v = new \PROJ\View\DemoGmap();
        $r = $v->getContent();

        return $r;
    }
    
    function isHtml() {
        if(@!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;
        else
            return false;
    }

}

?>