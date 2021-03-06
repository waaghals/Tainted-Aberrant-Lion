<?php

namespace PROJ\Tests;

use PROJ\Controllers\AjaxController;

class ProjectsTest extends \PHPUnit_Framework_TestCase
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
        $this->dummydata['type'] = "minor";
        $this->dummydata['location'] = "1";
        $this->dummydata['start_year'] = "2014";
        $this->dummydata['start_month'] = "2";
        $this->dummydata['end_year'] = "2014";
        $this->dummydata['end_month'] = "8";
    }

    public function testProjectInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationEmptyFieldFail()
    {
        $this->ResetData();

        $this->dummydata['start_year'] = "";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationFieldToLongFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "Lorem ipsum dolor sit amet, nonummy ligula volutpat hac integer nonummy. Suspendisse ultricies, congue etiam tellus, erat libero, nulla eleifend, mauris pellentesque. Suspendisse integer praesent vel, integer gravida mauris, fringilla vehicula lacinia non";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationSpecialCharactersFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "test ßtreet1";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationActionFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "delete";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationTypeFail()
    {
        $this->ResetData();

        $this->dummydata['type'] = "Both";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationStartAfterEndDate()
    {
        $this->ResetData();

        $this->dummydata['end_year'] = "2012";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function testProjectInputValidationInvalidDate()
    {
        $this->ResetData();

        $this->dummydata['start_month'] = "a";

        $this->assertNotEquals($this->controller->saveProjectAction($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
