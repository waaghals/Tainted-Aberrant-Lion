<?php

namespace PROJ\Controllers;

use PROJ\Helper\HeaderHelper;
use PROJ\Helper\XssHelper;
use PROJ\Helper\RightHelper;
use PROJ\Classes\PHPExcel\IOFactory;
use PROJ\Entities\Institute;
use PROJ\Entities\Project;
use PROJ\Entities\Review;
use PROJ\DBAL\ApprovalStateType as Status;
use PROJ\DBAL\ProjectType;
use PROJ\DBAL\InstituteType;

/**
 * @author Thijs
 */
class ManagementController extends BaseController
{

    private $page;
    private $additionalVals = array();

    public function homeAction()
    {
        $this->page = "Home";
        $this->serveManagementTemplate();
    }

    public function myReviewsAction()
    {
        $this->page = "MyReviews";
        $this->serveManagementTemplate();
    }

    public function myLocationsAction()
    {
        $this->page = "MyLocation";
        $this->serveManagementTemplate();
    }

    public function myProjectsAction()
    {
        $this->page = "MyProjects";
        $this->serveManagementTemplate();
    }

    public function UsersAction()
    {
        if (RightHelper::loggedUserHasRight("VIEW_USERS")) {
            $this->page = "ViewUsers";
            $this->serveManagementTemplate();
        }
    }

    public function LocationsAction()
    {
        if (RightHelper::loggedUserHasRight("VIEW_LOCATIONS")) {
            $this->page = "ViewLocations";
            $this->serveManagementTemplate();
        }
    }

    public function ProjectsAction()
    {
        if (RightHelper::loggedUserHasRight("VIEW_PROJECTS")) {
            $this->page = "ViewProjects";
            $this->serveManagementTemplate();
        }
    }

    public function ReviewsAction()
    {
        if (RightHelper::loggedUserHasRight("VIEW_REVIEWS")) {
            $this->page = "ViewReviews";
            $this->serveManagementTemplate();
        }
    }

    public function CreateUserAction()
    {
        if (RightHelper::loggedUserHasRight("CREATE_USER")) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Create new account
                $valid = $this->validateCreateUser();
                if ($valid === "succes") {
                    $this->additionalVals = array('error' => 'Created access code succesfully.');
                } else {
                    $this->additionalVals = array('error' => $valid);
                }
            }
            $this->page = "CreateUser";
            $this->serveManagementTemplate();
        }
    }

    public function changePasswordAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Save account details
            $valid = $this->validateChangePassword();
            if ($valid === "succes") {
                $this->additionalVals = array('error' => 'Change password succesfully.');
            } else {
                $this->additionalVals = array('error' => $valid);
            }
        }
        $this->page = "ChangePassword";
        $this->serveManagementTemplate();
    }

    public function myAccountAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Save account details
            $valid = $this->validateInput($_POST);
            if ($valid === "succes") {
                $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
                $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID'])->getStudent();

                $user->setCity($_POST['city']);
                $user->setZipcode($_POST['zipcode']);
                $user->setStreet($_POST['street']);
                $user->setHousenumber($_POST['housenumber']);
                $user->setAddition($_POST['addition']);
                $user->setEmail($_POST['email']);
                $em->persist($user);
                $em->flush();
                $this->additionalVals = array('error' => 'Successfully saved.');
            } else {
                $this->additionalVals = array('error' => $valid);
            }
        }
        $this->page = "MyAccount";
        $this->serveManagementTemplate();
    }

    private function serveManagementTemplate()
    {
        $ac = new \PROJ\Services\AccountService();
        if (!$ac->isLoggedIn()) {
            HeaderHelper::redirect("/");
            return;
        }

        $t = new \PROJ\Tools\Template("Management");
        $t->page = $this->page;
        $t->additionalValues = $this->additionalVals;
        echo $t;
    }

    /**
     *  Function to validate the input entered when changing credentials.
     * @param type $data (POST)
     * @return string
     */
    private function validateInput($data)
    {
        if (empty($data['city']) || empty($data['zipcode']) || empty($data['street']) || empty($data['housenumber']) || empty($data['email'])) {
            return "Not everything is filled in";
        }
        foreach ($data as $input) {
            if ($input == $data['housenumber']) {
                break;
            }
            if (strlen($input) > 254) {
                return "Some fieldes are too long.";
            }
            if (!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input)) {
                return "No special characters allowed";
            }
        }
        if (!(filter_var($data['housenumber'], FILTER_VALIDATE_INT))) {
            return "House number is not a number";
        }

        return "succes";
    }

    /**
     * Function to validate if the new entered passwords are allowed.
     * @return string
     */
    private function validateChangePassword()
    {
//Get current user
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);

//Valdidate old password
        $passwordEnteredOld = hash('sha512', $_POST['old_password'] . $user->getSalt());
        if ($passwordEnteredOld == $user->getPassword()) {
            if ($_POST['old_password'] != $_POST['new_password']) {
                if ($_POST['new_password'] == $_POST['rep_new_password']) {
                    $passwordEnteredNew = hash('sha512', $_POST['new_password'] . $user->getSalt());
                    $user->setPassword($passwordEnteredNew);
                    $em->persist($user);
                    $em->flush();

//Change session to prevent logout
                    $_SESSION['login_string'] = hash('sha512', $user->getPassword() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);

                    return "succes";
                } else {
                    return "New passwords didn't match.";
                }
            } else {
                return "New password can't be the same as the old password.";
            }
        } else {
            return "Old password didn't match.";
        }
    }

    /**
     * Function to validate the Create User form.
     * Also saves code to the database.
     * @return string
     */
    private function validateCreateUser()
    {
        if (empty($_POST['email']) || empty($_POST['rep_email'])) {
            return "Not everything is filled in";
        }

        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();
        if ($ac->isLoggedIn()) {
            if ($_POST['email'] == $_POST['rep_email']) {
//Check if the email already has an activation code. If so; just resent the email
                $RegCode = $em->getRepository('\PROJ\Entities\RegistrationCode')->findBy(array('email' => $_POST['email']));
                if (count($RegCode) > 0) {
                    $this->sendActivationMail($RegCode->getEmail(), $RegCode->getCode());
                } else {
                    $code = sha1(mt_rand(1, 99999) . time() . session_id());
//Prevents duplicate codes
                    while (count($em->getRepository('\PROJ\Entities\RegistrationCode')->findBy(array('code' => $code))) > 0) {
                        $code = sha1(mt_rand(1, 99999) . time() . session_id());
                    }

                    $activation = new \PROJ\Entities\RegistrationCode();
                    $activation->setCode($code);
                    $activation->setEmail(XssHelper::sanitizeInput($_POST['email']));

                    $em->persist($activation);
                    $em->flush();

                    $this->sendActivationMail(XssHelper::sanitizeInput($_POST['email']), $code);
                }
                return "succes";
            } else {
                return "E-Mail fiels do not match.";
            }
        } else {
            return "Not Logged In";
        }
    }

    private function sendActivationMail($to, $code)
    {
        $message = "This is your personal activation code to create a account on the Avans WorldMap.\n\rThis code is linked to your E-Mail adress.\n\r\n\rYour code is: " . $code . "\n\r\n\rClick the following link to register: http://stable.toip.nl/account/Register/?registrationcode=" . $code;
        $headers = "From: coordinator@toip.nl\r\n" .
                "Reply-To: no-reply@toip.nl\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, "Creation code for Avans WorldMap", $message, $headers);
    }

    public function uploadAction()
    {
        if (RightHelper::loggedUserHasRight("UPLOAD_EXCEL")) {
            $this->page = "Upload";
            $this->serveManagementTemplate();
        }
    }

    public function uploadFileAction()
    {
        if (RightHelper::loggedUserHasRight("UPLOAD_EXCEL")) {
            $file = $_FILES["file"];
            $allowed = $this->isFileAllowed($file);
            var_dump($this->isFileValid($file["tmp_name"]));
            die();
            if ($allowed) {
                $this->processExcel($file["tmp_name"]);
            } else {
                foreach ($allowed as $message) {
                    echo $message;
                }
            }
        }
    }

    /*
     * Dynamic use of php.
     * Return true if the file is allowed.
     * Return array containing error messages if the file
     * is not allowed.
     */

    private function isFileAllowed($file)
    {
        $errormsg = array();
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        if (!($extension === "xlsx" || $extension === "xls")) {
            $errormsg[] = "The used file extension isn't allowed.";
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $errormsg[] = "The used file is too big.";
        }
        if ($_FILES["file"]["error"] > 0) {
            $errormsg[] = "Error: " . $file["error"] . "<br />";
        }
        if (sizeof($errormsg) == 0) {
            return true;
        }
        return $errormsg;
    }

    private function processExcel($excelFile)
    {
        // load the excelFile in the PHPExcel object
        $objPHPExcel = IOFactory::load($excelFile);
        // Set the sheet of the file to the first one
        $objPHPExcel->setActiveSheetIndex(0);
        $this->processUserSheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->setActiveSheetIndex(1);
        $this->processInstituteSheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->setActiveSheetIndex(2);
        $this->processProjectSheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->setActiveSheetIndex(3);
        $this->processReviewSheet($objPHPExcel->getActiveSheet());
    }

    private function processUserSheet($sheet)
    {
        $AccountService = new \PROJ\Services\AccountService();
        foreach (array_slice($sheet->toArray(), 1) as $userData) {
            $user["username"] = $userData[10];
            $user["password"] = $userData[11];
            if ($user["username"] > 254 || $user["username"] == null) {
                break;
            } else if ($user["password"] > 254 || $user["password"] == null) {
                break;
            }
            $account = $AccountService->createAccount($user);
            $student["firstname"] = $userData[2];
            $student["surname"] = $userData[3];
            $student["city"] = $userData[4];
            $student["zipcode"] = $userData[5];
            $student["street"] = $userData[6];
            $student["streetnumber"] = $userData[7];
            $student["addition"] = $userData[8];
            $student["email"] = $userData[9];
            $AccountService->createStudent($account, $student);
        }
    }

    private function processInstituteSheet($sheet)
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $acc = $em->getRepository('PROJ\Entities\Account')->find($_SESSION['userID']);
        foreach (array_slice($sheet->toArray(), 1) as $instituteData) {
            $institute = new Institute();
            if ($instituteData[2] == "education") {
                $institute->setType(InstituteType::EDUCATION);
            } else if ($instituteData[2] == "business") {
                $institute->setType(InstituteType::BUSINESS);
            } else {
                break;
            }
            $institute->setCreator($acc->getStudent());
            $institute->setName($instituteData[1]);
            $institute->setLat($instituteData[3]);
            $institute->setLng($instituteData[4]);
            $institute->setPlace($instituteData[5]);
            $institute->setStreet($instituteData[6]);
            $institute->setHousenumber($instituteData[7]);
            $institute->setPostalcode($instituteData[8]);
            $institute->setEmail($instituteData[9]);
            $institute->setTelephone($instituteData[10]);
            $institute->setAcceptanceStatus(Status::APPROVED);
            $institute->setCountry($em->getRepository('\PROJ\Entities\Country')->findOneBy(array('name' => $instituteData[11])));
            if ($this->isInstituteValid($instituteData)) {
                $em->persist($acc);
                $em->persist($institute);
            }
        }
        $em->flush();
    }

    private function isFileValid($file)
    {
        $objPHPExcel = IOFactory::load($file);
        $sheetCount = $objPHPExcel->getSheetCount();
        for ($i = 0; $i < $sheetCount; $i++) {
            $objPHPExcel->setActiveSheetIndex($i);
            $sheet = $objPHPExcel->getActiveSheet()->toArray();
            foreach ($sheet as $row) {
                foreach ($row as $item) {
                    if ($item == null) {
                        return false;
                    }
                }
            }
            $i++;
        }

        return true;
    }

    private function processProjectSheet($sheet)
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        foreach (array_slice($sheet->toArray(), 1) as $projectData) {
            $project = new Project();
            $project->setStudent($this->getStudentFromExcelId($sheet->getParent(), $projectData[0]));
            $project->setInstitute($this->getInstituteFromExcelId($sheet->getParent(), $projectData[2]));
            $project->setStartdate($this->getDateTimeFromExcel($projectData[3]));
            $project->setEnddate($this->getDateTimeFromExcel($projectData[4]));
            switch ($projectData[5]) {
                case "Stage":
                    $project->setType(ProjectType::INTERNSHIP);
                    break;
                case "Minor":
                    $project->setType(ProjectType::MINOR);
                    break;
                case "Afstudeerstage":
                    $project->setType(ProjectType::GRADUATION);
                    break;
                case "EPS":
                    $project->setType(ProjectType::EPS);
                    break;
            }
            $project->setAcceptanceStatus(Status::APPROVED);
            $em->persist($project);
        }
        $em->flush();
    }

    private function processReviewSheet($sheet)
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        foreach (array_slice($sheet->toArray(), 1) as $reviewData) {
            $review = new Review();
            $project = $this->getProjectFromExcelId($sheet->getParent(), $reviewData[0]);
            $review->setProject($project);
            $review->setRating($reviewData[1]);
            $review->setText($reviewData[2]);
            $review->setAssignmentRating($reviewData[3]);
            $review->setGuidanceRating($reviewData[4]);
            $review->setAccommodationRating($reviewData[5]);
            $review->setAcceptanceStatus(Status::APPROVED);
            if ($review->getText() != null && $project != null) {
                $em->persist($review);
                $em->persist($project);
            }
        }
        $em->flush();
    }

    private function getDateTimeFromExcel($cel)
    {
        $date = \DateTime::createFromFormat("j-M-y", $cel);
        return $date;
    }

    // PHPExcel reader, int
    private function getStudentFromExcelId($objPHPExcel, $studentId)
    {
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet()->toArray();
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        foreach (array_slice($sheet, 1) as $studentData) {
            if ($studentData[0] == $studentId) {
                $account = $em->getRepository('\PROJ\Entities\Account')->findOneBy(array('username' => $studentData[10]));
                return $student = $account->getStudent();
            }
        }
    }

    // PHPExcel reader, int
    private function getInstituteFromExcelId($objPHPExcel, $instituteId)
    {
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet = $objPHPExcel->getActiveSheet()->toArray();
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        foreach (array_slice($sheet, 1) as $instituteData) {
            if ($instituteData[0] == $instituteId) {
                return $em->getRepository('\PROJ\Entities\Institute')->findOneBy(array(
                            'name' => $instituteData[1],
                            'lat' => $instituteData[3],
                            'lng' => $instituteData[4]
                ));
            }
        }
    }

    private function getProjectFromExcelId($objPHPExcel, $projectId)
    {
        $objPHPExcel->setActiveSheetIndex(2);
        $sheet = $objPHPExcel->getActiveSheet()->toArray();
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        foreach (array_slice($sheet, 1) as $projectData) {
            if ($projectData[1] == $projectId) {
                $student = $this->getStudentFromExcelId($objPHPExcel, $projectData[0]);
                return $em->getRepository('\PROJ\Entities\Project')->findOneBy(array(
                            'student' => $student
                ));
            }
        }
    }

}
