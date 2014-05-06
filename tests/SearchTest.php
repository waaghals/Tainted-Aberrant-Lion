<?php

namespace PROJ\Tests;

use PROJ\Services\AccountService;

class SearchTest extends \PHPUnit_Framework_TestCase
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
        $this->dummydata['firstname'] = "Dummy";
        $this->dummydata['surname'] = "Dummy";
        $this->dummydata['city'] = "Dummy";
        $this->dummydata['street'] = "Dummy";
        $this->dummydata['email'] = "Dummy";
        $this->dummydata['projecttype'] = "Dummy";
        $this->dummydata['institutetype'] = "Dummy";
        $this->dummydata['instituteplace'] = "Dummy";
    }

    public function testSearchInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationFirstnameFail()
    {
        $this->ResetData();

        $this->dummydata['firstname'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationSurnameFail()
    {
        $this->ResetData();

        $this->dummydata['surname'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationCityFail()
    {
        $this->ResetData();

        $this->dummydata['city'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationStreetFail()
    {
        $this->ResetData();

        $this->dummydata['street'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationEmailFail()
    {
        $this->ResetData();

        $this->dummydata['email'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationProjectTypeFail()
    {
        $this->ResetData();

        $this->dummydata['projecttype'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationInstitutionTypeFail()
    {
        $this->ResetData();

        $this->dummydata['institutetype'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function testSearchInputValidationInstitutionPlaceFail()
    {
        $this->ResetData();

        $this->dummydata['instituteplace'] = "NotDummy";

        $this->assertNotEquals($this->service->validateInput($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
