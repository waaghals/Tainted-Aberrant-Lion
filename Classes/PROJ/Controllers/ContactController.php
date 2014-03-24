<?php

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use PROJ\Services\ContactService;

/**
 * Description of Contact
 *
 * @author Sam
 */
class ContactController extends BaseController {

    private $service;

    public function __construct() {
        $this->service = new ContactService();
    }

    public function showAction($studentId) {
        $student = $this->service->getStudentById($studentId);

        $t1 = new \PROJ\Tools\Template("ContactFormSucces");
        $t = new \PROJ\Tools\Template("ContactForm");
        $t->studentId = $studentId;
        $t->studentName = $student->getFullName();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['mailFrom']) || empty($_POST['mailSubject']) || empty($_POST['mailContent'])) {
                $t->error = "One of the fields isn't filled in.";
            }elseif(!filter_var($_POST['mailFrom'], FILTER_VALIDATE_EMAIL)) {
                $t->error = "From field isn't a valid E-mail adress.";
            }else{
                $student = $this->service->getStudentById($studentId);

                $this->service->sendMail($student->getEmail());
                echo $t1;
                exit;
            }
        }

        echo $t;
    }

}
