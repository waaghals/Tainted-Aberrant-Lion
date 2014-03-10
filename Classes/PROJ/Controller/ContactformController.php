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
    
    public function getName()
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $s = $em->getRepository('/PROJ/Entities/Student')->find(1);
        return $s->getVoornaam()." ".$s->getAchternaam();
    }
    
    public function getMail()
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $s = $em->getRepository('/PROJ/Entities/Student')->find(1);
        return $s->getEmail();
    }
    
    public function sendMail()
    {
        mail($this->getMail(), $_POST['subject'], filter_var($_POST['mailContent'], FILTER_SANITIZE_FULL_SPECIAL_CHARS), 'From: '.$_POST['mailFrom']);
    }
    
}
