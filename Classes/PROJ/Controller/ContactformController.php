<?php

namespace PROJ\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactformController
 *
 * @author Sam
 */
class ContactformController {
        
    function __construct() {
        
    }
    
    public function getMail()
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $s = $em->getRepository('/PROJ/Entities/Student')->find(1);
        return $s->getEmail();
    }
    
    public function sendMail()
    {
        mail($_POST['mailTo'], $_POST['subject'], $_POST['mailContent'], 'From: '.$_POST['mailFrom']);
    }
    
}
