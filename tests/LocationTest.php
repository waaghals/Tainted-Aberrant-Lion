<?php

namespace PROJ\Tests;

use PROJ\Controllers\AjaxController;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{

    public $dummydata;
    public $controller;

    public function __construct()
    {
        // $this->ResetData();
        $this->controller = new AjaxController();
    }

    public function ResetData()
    {
        $this->dummydata['id'] = "1";
        $this->dummydata['action'] = "create";
        $this->dummydata['type'] = "business";
        $this->dummydata['name'] = "Dummy Business";
        $this->dummydata['country'] = "167";
        $this->dummydata['city'] = "Dummy";
        $this->dummydata['street'] = "Dummy";
        $this->dummydata['housenumber'] = "666";
        $this->dummydata['postalcode'] = "Dummy";
        $this->dummydata['email'] = "contact@dummies.nl";
    }

    public function testRegistrationInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationEmptyFieldFail()
    {
        $this->ResetData();

        $this->dummydata['street'] = "";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationFieldToLongFail()
    {
        $this->ResetData();

        $this->dummydata['name'] = "Lorem ipsum dolor sit amet, nonummy ligula volutpat hac integer nonummy. Suspendisse ultricies, congue etiam tellus, erat libero, nulla eleifend, mauris pellentesque. Suspendisse integer praesent vel, integer gravida mauris, fringilla vehicula lacinia non";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationSpecialCharactersFail()
    {
        $this->ResetData();

        $this->dummydata['street'] = "test ßtreet1";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationHouseNumberFail()
    {
        $this->ResetData();

        $this->dummydata['housenumber'] = "123A";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationActionFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "delete";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function testLocationInputValidationTypeFail()
    {
        $this->ResetData();

        $this->dummydata['type'] = "Both";

        $this->assertNotEquals($this->controller->saveLocationAction($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
