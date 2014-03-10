<?php

require("../Classes/PROJ/Controller/RegisterController.php");
require("../Classes/PROJ/Pages/Register.php");
require("../Classes/PROJ/Pages/MainPage.php");

class RegistrationTest extends \PHPUnit_Framework_TestCase {

    public $dummydata;
    public $RegisterController;
            
    public function __construct(){
        $this->ResetData();
        $RegisterController = new \PROJ\Controller\RegisterController();
    } 
    
    public function ResetData(){
        $dummydata['username'] = "Dummy";
        $dummydata['password'] = "Dummy";
        $dummydata['passwordagain'] = "Dummy";
        $dummydata['firstname'] = "Dummy";
        $dummydata['surname'] = "Dummy";
        $dummydata['city'] = "Dummy";
        $dummydata['street'] = "Dummy";
        $dummydata['zipcode'] = "Dummy";
    }
    
    public function RegistrationInputValidationCheckPass() {
        $this->ResetData();
        
        $this->assertEquals($RegisterController->validate_input($dummydata), "Registration succeeded!");
    }
    
    public function RegistraionInputValidationUsernameFail(){
        $this->ResetData();
        
        $dummydata['username'] = "<script>alert('hoi');</script>";
        
        $this->assertNotEquals($RegisterController->validate_input($dummydata), "Registration succeeded!");
    }
    
    public function RegistraionInputValidationPasswordNotEquals(){
        $this->ResetData();
        
        $dummydata['passwordagain'] = "NotDummy";
        
        $this->assertNotEquals($RegisterController->validate_input($dummydata), "Registration succeeded!");
    }
    
    

}
?>