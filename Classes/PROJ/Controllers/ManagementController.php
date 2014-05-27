<?php

namespace PROJ\Controllers;

use PROJ\Helper\HeaderHelper;
use PROJ\Helper\XssHelper;
use PROJ\Helper\RightHelper;

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
        $message = "This is your personal activation code to create a account on the Avans WorldMap.\n\rThis code is linked to your E-Mail adress.\n\r\n\rYour code is: " . $code . "\n\r\n\r<a href=\"http://stable.toip.nl/account/Register/?registrationcode=" . $code . "\">Click here to register.</a>";
        $headers = "From: coordinator@toip.nl\r\n" .
                "Reply-To: no-reply@toip.nl\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, "Creation code for Avans WorldMap", $message, $headers);
    }

    public function UploadAction()
    {
        if (RightHelper::loggedUserHasRight("UPLOAD_EXCEL")) {
            $this->page = "Upload";
            $this->serveManagementTemplate();
        }
    }

    public function UploadFileAction()
    {
        if (RightHelper::loggedUserHasRight("UPLOAD_EXCEL")) {
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($extension === "xlsx" || $extension === "xls") {
                if ($_FILES["file"]["size"] < 1000000) {
                    if ($_FILES["file"]["error"] > 0) {
                        echo "Error: " . $_FILES["file"]["error"] . "<br>";
                    } else {
                        // TODO: process file
                        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                        echo "Type: " . $_FILES["file"]["type"] . "<br>";
                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                        echo "Stored in: " . $_FILES["file"]["tmp_name"];
                    }
                } else {
                    echo "Filesize is too big.";
                }
            } else {
                echo "Invalid file type.";
            }
        }
    }

}
