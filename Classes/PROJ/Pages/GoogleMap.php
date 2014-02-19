<?php

namespace PROJ\Pages;

class GoogleMap extends MainPage {

    public function getContent() {
        $v = new \PROJ\View\DemoGmap();
        $r = $v->getContent();

        return $r;
    }
    
    function isHtml() {
        if(@!$_POST['markerRequest'] == 'true')
            return true;
        else
            return false;
    }

}

?>