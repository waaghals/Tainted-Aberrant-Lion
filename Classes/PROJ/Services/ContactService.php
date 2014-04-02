<?php

namespace PROJ\Services;

use PROJ\Exceptions\ServerException;

/**
 * Description of ContactformController
 *
 * @author Sam
 */
class ContactService {

    public function sendMail($toEmail) {
        $subject = filter_var($_POST['mailSubject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $message = filter_var($_POST['mailContent'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $headers = 'From: '.filter_var($_POST['mailFrom'], FILTER_VALIDATE_EMAIL). "\r\n" .
            'Reply-To: '.filter_var($_POST['mailFrom'], FILTER_VALIDATE_EMAIL). "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($toEmail, $subject, $message, $headers);
    }

    public function getStudentById($studentId) {
        if (!is_int(intval($studentId))) {
            $msg = sprintf("StudentId with value: %s is not a valid id.", $studentId);
            throw new ServerException($msg, ServerException::SERVER_ERROR);
        }

        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $student = $em->getRepository('\PROJ\Entities\Student')->find($studentId);

        if ($student == null) {
            $msg = sprintf("A student with id: %s does not exists in the database.", $studentId);
            throw new ServerException($msg, ServerException::NOT_FOUND);
        }
        
        if (!is_a($student, "\PROJ\Entities\Student")) {
            \Doctrine\Common\Util\Debug::dump($student);
            $msg = "A unexpected object was returned from the database.";
            throw new ServerException($msg, ServerException::SERVER_ERROR);
        }

        

        //Student is valid
        return $student;
    }

}
