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
        $this->dummydata['username'] = "Dummy";
        $this->dummydata['password'] = "Dummy";
        $this->dummydata['passwordagain'] = "Dummy";
        $this->dummydata['firstname'] = "Dummy";
        $this->dummydata['surname'] = "Dummy";
        $this->dummydata['city'] = "Dummy";
        $this->dummydata['street'] = "Dummy";
        $this->dummydata['zipcode'] = "Dummy";
    }

    public function testRegistrationInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testRegistrationInputValidationUsernameFail()
    {
        $this->ResetData();

        $this->dummydata['username'] = "<script>alert('hoi');</script>";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testRegistrationInputValidationPasswordNotEquals()
    {
        $this->ResetData();

        $this->dummydata['passwordagain'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
