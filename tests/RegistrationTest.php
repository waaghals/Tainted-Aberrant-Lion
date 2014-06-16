<?php

namespace PROJ\Tests;

use PROJ\Services\AccountService;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{

    public $dummydata;
    public $service;

    public function __construct()
    {
        // $this->ResetData();
        $this->service = new AccountService();
    }

    public function ResetData()
    {
        $this->dummydata['username']         = "Patrick";
        $this->dummydata['password']         = "test";
        $this->dummydata['passwordagain']    = "test";
        $this->dummydata['firstname']        = "Patrick";
        $this->dummydata['surname']          = "Berenschot";
        $this->dummydata['city']             = "'s -Hertogenbosch";
        $this->dummydata['street']           = "Straatnaam";
        $this->dummydata['zipcode']          = "5111AA";
        $this->dummydata['streetnumber']     = "256";
        $this->dummydata['registrationcode'] = "abc";
    }

    public function testRegistrationInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->service->validateInput($this->dummydata),
                                                          true);
    }

    public function testRegistrationInputValidationUsernameFail()
    {
        $this->ResetData();

        $this->dummydata['username'] = "<script>alert('hoi');</script>";

        $this->assertNotEquals($this->service->validateInput($this->dummydata),
                                                             true);
    }

    public function testRegistrationInputValidationPasswordNotEquals()
    {
        $this->ResetData();

        $this->dummydata['passwordagain'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata),
                                                             true);
    }

    public function __toString()
    {
        return "";
    }

}
