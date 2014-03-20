<?php

namespace PROJ\Tests;

use PROJ\Services\AccountService;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{

    public $dummydata = array();
    public $service;

    public function __construct()
    {
        // $this->ResetData();
        $this->service = new AccountService();
    }

    public function setUp()
    {
        $mock = $this->getMockBuilder('AccountService')
                ->setMethods(array('checkUsernameExists', 'true'))
                ->getMock();
        $this->dummydata['username'] = "Dummy";
        $this->dummydata['password'] = "Dummy";
        $this->dummydata['passwordagain'] = "Dummy";
        $this->dummydata['firstname'] = "Dummy";
        $this->dummydata['surname'] = "Dummy";
        $this->dummydata['city'] = "Dummy";
        $this->dummydata['email'] = "Dummy@example.com";
        $this->dummydata['street'] = "Dummy";
        $this->dummydata['zipcode'] = "Dummy";
        $this->dummydata['streetnumber'] = 12;
    }

    public function testRegistrationInputValidationCheckPass()
    {

        $this->assertTrue($this->service->validateInput($this->dummydata));
    }

    public function testRegistraionInputValidationUsernameFail()
    {
        $this->dummydata['username'] = "<script>alert('hoi');</script>";

        $this->assertTrue($this->service->validateInput($this->dummydata));
    }

    public function testRegistraionInputValidationPasswordNotEquals()
    {
        $this->dummydata['passwordagain'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testRegistraionInputValidationInputLengthFail()
    {
        $this->dummydata['username'] = "";
        // string length = 321
        $dummydata['firstname'] = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testRegistraionInputValidationNoInput()
    {
        foreach ($this->dummydata as $data)
            $data = "";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
