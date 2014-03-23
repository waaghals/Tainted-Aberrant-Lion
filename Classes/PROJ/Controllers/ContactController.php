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

    public function sendAction($studentId) {
        if (!isset($_POST['submit'])) { 
           //Form was not submitted, nothing to send.
            $msg = "No post data was sent to the server.";
            throw new ServerException($msg, ServerException::BAD_REQUEST);
        }

        $student = $this->service->getStudentById($studentId);

        $this->service->sendMail($student->getEmail());
        echo "Email send.";
    }

    public function showAction($studentId) {
        $student = $this->service->getStudentById($studentId);

        $t = new \PROJ\Tools\Template("ContactForm");
        $t->studentId = $studentId;
        $t->studentName = $student->getFullName();

        echo $t;
    }

}
