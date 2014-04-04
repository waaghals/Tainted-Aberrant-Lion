<?php

namespace PROJ\Controllers;

use PROJ\Helper\HeaderHelper;

/**
 * @author Thijs
 */
class ManagementController extends BaseController {
    private $page;
    private $additionalVals = array();
    
    public function homeAction() {
        $this->page = "Home";
        $this->serveManagementTemplate();
    }
    
    public function ChangePasswordAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Save account details
            $valid = $this->validate_ChangePassword();
            if($valid === "succes") {
                $this->additionalVals = array('error'=>'Change password succesfully.');
            }else{
                $this->additionalVals = array('error'=>$valid);
            }
        }
        $this->page = "ChangePassword";
        $this->serveManagementTemplate();
    }
    
    public function MyAccountAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Save account details
            $valid = $this->validate_input($_POST);
            if($valid === "succes"){
                $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
                $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID'])->getStudent();
                
                $user->setCountry($_POST['country']);
                $user->setCity($_POST['city']);
                $user->setZipcode($_POST['zipcode']);
                $user->setStreet($_POST['street']);
                $user->setHousenumber($_POST['housenumber']);
                $user->setAddition($_POST['addition']);
                $user->setEmail($_POST['email']);
                $em->persist($user);
                $em->flush();
                $this->additionalVals = array('error'=>'Successfully saved.');
            }else{
                $this->additionalVals = array('error'=>$valid);
            }
        }
        $this->page = "MyAccount";
        $this->serveManagementTemplate();
    }
    
    private function serveManagementTemplate() {
        $ac = new \PROJ\Services\AccountService();
        if(!$ac->isLoggedIn()) {
            HeaderHelper::redirect("/");
            return;
        }
        
        $t = new \PROJ\Tools\Template("Management");
        $t->page = $this->page;
        $t->additionalValues = $this->additionalVals;
        echo $t;
    }
    
    private function validate_input($data) {
        if (empty($data['country']) || empty($data['city']) 
                || empty($data['zipcode']) || empty($data['street']) || empty($data['housenumber']) || empty($data['email'])) {
            return "Not everything is filled in";
        }
        foreach($data as $input){
            if($input == $data['housenumber'])
                break;
            if(strlen($input) > 254)
                return "Some fieldes are too long.";
            if(!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input))
                return "No special characters allowed";
        }
        if(!(filter_var($data['housenumber'], FILTER_VALIDATE_INT)))
                return "House number is not a number";
        
        return "succes";
    }
    
    private function validate_ChangePassword() {
        //Get current user
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);
        
        //Valdidate old password
        $passwordEnteredOld = hash('sha512', $_POST['old_password'] . $user->getSalt());
        if($passwordEnteredOld == $user->getPassword()) {
            if($_POST['old_password'] != $_POST['new_password']) {
                if($_POST['new_password'] == $_POST['rep_new_password']) {
                    $passwordEnteredNew = hash('sha512', $_POST['new_password'] . $user->getSalt());
                    $user->setPassword($passwordEnteredNew);
                    $em->persist($user);
                    $em->flush();
                    
                    //Change session to prevent logout
                    $_SESSION['login_string'] = hash('sha512', $user->getPassword() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                    
                    return "succes";
                }else{
                    return "New passwords didn't match.";
                }
            }else{
                return "New password can't be the same as the old password.";
            }
        }else{
            return "Old password didn't match.";
        }
    }

}
