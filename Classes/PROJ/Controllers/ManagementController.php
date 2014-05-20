<?php

namespace PROJ\Controllers;

use PROJ\Helper\HeaderHelper;
use PROJ\Helper\XssHelper;
use PROJ\Classes\PHPExcel\IOFactory;
use PROJ\Entities\Institute;

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
        $this->page = "ViewUsers";
        $this->serveManagementTemplate();
    }

    public function CreateUserAction()
    {
//TODO: Add coordinator check
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
        $message = "This is your personal activation code to create a account on the Avans WorldMap.\n\rThis code is linked to your E-Mail adress.\n\r\n\rYour code is: " . $code;
        $headers = "From: coordinator@toip.nl\r\n" .
                "Reply-To: no-reply@toip.nl\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, "Creation code for Avans WorldMap", $message, $headers);
    }

    public function UploadAction()
    {
        $this->page = "Upload";
        $this->serveManagementTemplate();
    }

    public function UploadFileAction()
    {
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if ($extension === "xlsx") {
            if ($_FILES["file"]["size"] < 1000000) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Error: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    $this->processExcel($_FILES["file"]["tmp_name"]);
                }
            } else {
                echo "Filesize is too big.";
            }
        } else {
            echo "Invalid file type.";
        }
    }

    private function processExcel($excelFile)
    {
        // load the excelFile in the PHPExcel object
        $objPHPExcel = IOFactory::load($excelFile);
        // Set the sheet of the file to the first one
        $objPHPExcel->setActiveSheetIndex(0);
        $this->processUserSheet($objPHPExcel->getActiveSheet()->toArray());
        $objPHPExcel->setActiveSheetIndex(1);
        $this->processInstituteSheet($objPHPExcel->getActiveSheet()->toArray());
    }

    private function processUserSheet($sheet)
    {
        $AccountService = new \PROJ\Services\AccountService();
        foreach (array_slice($sheet, 1) as $userData) {
            $user["username"] = $userData[10];
            $user["password"] = $userData[11];
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
        foreach (array_slice($sheet, 1) as $instituteData) {
            $institute = new Institute();
            $institute->setCreator($acc->getStudent());
            $institute->setName($instituteData[1]);
            $institute->setType($instituteData[2]);
            $institute->setLat($instituteData[3]);
            $institute->setLng($instituteData[4]);
            $institute->setPlace($instituteData[5]);
            $institute->setStreet($instituteData[6]);
            $institute->setHousenumber($instituteData[7]);
            $institute->setPostalcode($instituteData[8]);
            $institute->setEmail($instituteData[9]);
            $institute->setTelephone($instituteData[10]);
            $institute->setCountry($em->getRepository('\PROJ\Entities\Country')->findOneBy(array('name' => $instituteData[11])));
            $em->persist($acc);
            $em->persist($institute);
        }
        $em->flush();
    }

}
