<?php

namespace PROJ\Tests;

use PROJ\Controllers\AjaxController;

class CoordinatorUsersTest extends \PHPUnit_Framework_TestCase
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
        $this->dummydata['firstname'] = "Thijs";
        $this->dummydata['surname'] = "Dalmaijer";
        $this->dummydata['username'] = "thijsd";
    }

    public function testCoordinatorUsersInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function testCoordinatorUsersInputValidationEmptyFieldFail()
    {
        $this->ResetData();

        $this->dummydata['username'] = "";

        $this->assertNotEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function testCoordinatorUsersInputValidationFieldToLongFail()
    {
        $this->ResetData();

        $this->dummydata['firstname'] = "Lorem ipsum dolor sit amet, nonummy ligula volutpat hac integer nonummy. Suspendisse ultricies, congue etiam tellus, erat libero, nulla eleifend, mauris pellentesque. Suspendisse integer praesent vel, integer gravida mauris, fringilla vehicula lacinia non";

        $this->assertNotEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function testCoordinatorUsersInputValidationSpecialCharactersFail()
    {
        $this->ResetData();

        $this->dummydata['surname'] = "test ßtreet1";

        $this->assertNotEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function testCoordinatorUsersInputValidationActionFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "delete";

        $this->assertNotEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function testCoordinatorUsersInputValidationIDFail()
    {
        $this->ResetData();

        $this->dummydata['id'] = "a";

        $this->assertNotEquals($this->controller->saveUserAction($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
