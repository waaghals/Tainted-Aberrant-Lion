<?php

namespace PROJ\View;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactformView
 *
 * @author Sam
 */
class ContactformView {
    
    function __construct() {
        
    }
    
    public function makeMailForm($email) {
        $c = new \PROJ\Controller\ContactformController();

        if (!isset($_POST['submit'])) {
            return "<div id='contact'>"
                        ."<form action='stable.toip.nl/Contact.php' method='GET'>"
                                ."To:<input type='email' name='mailTo' value='".$email."' disabled><br>"
                                ."From:<input type='email' name='mailFrom' value='' autofocus><br><br>"
                                ."Subject:<input type='text' name='subject' value=''><br>"
                                ."<textarea rows='25' cols='50' name='mailContent'></textarea><br><br>"
                                ."<input type='submit' name='submit' value='Send' style='margin-top: -10px; float: right;'>"
                        ."</form>"
                    ."</div>";
        }
        else {
            $c->sendMail();
            return "<div id='mailSend'>"
                    ."Uw e-mail is verzonden. Bedankt voor uw interesse!"
                    ."</div>";
        }
    }    
}
