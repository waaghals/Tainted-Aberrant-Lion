<?php

namespace PROJ\Pages;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contact
 *
 * @author Sam
 */
class Contact extends MainPage{
    
    public function getContent() {
        $v = new \PROJ\View\ContactformView();
        
        $r = $v->makeMailForm();

        return $r;
    }
    
}
