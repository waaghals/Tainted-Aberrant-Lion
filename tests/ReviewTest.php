<?php

namespace PROJ\Tests;

use PROJ\Controllers\AjaxController;

class ReviewTest extends \PHPUnit_Framework_TestCase
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
        $this->dummydata['project'] = "1";
        $this->dummydata['assignment_score'] = "2";
        $this->dummydata['guidance_score'] = "3";
        $this->dummydata['accomodation_score'] = "4";
        $this->dummydata['overall_score'] = "5";
        $this->dummydata['review'] = "Just do your job and they're happy.";
    }

    public function testReviewInputValidationCheckPass()
    {
        $this->ResetData();

        $this->assertEquals($this->controller->saveReviewAction($this->dummydata), true);
    }

    public function testReviewInputValidationEmptyFieldFail()
    {
        $this->ResetData();

        $this->dummydata['guidance_score'] = "";

        $this->assertNotEquals($this->controller->saveReviewAction($this->dummydata), true);
    }

    public function testReviewInputValidationActionFail()
    {
        $this->ResetData();

        $this->dummydata['action'] = "delete";

        $this->assertNotEquals($this->controller->saveReviewAction($this->dummydata), true);
    }

    public function testReviewInputValidationScoreFail()
    {
        $this->ResetData();

        $this->dummydata['guidance_score'] = "6";

        $this->assertNotEquals($this->controller->saveReviewAction($this->dummydata), true);
    }

    public function testReviewInputValidationNumericFail()
    {
        $this->ResetData();

        $this->dummydata['assignment_score'] = "a";

        $this->assertNotEquals($this->controller->saveReviewAction($this->dummydata), true);
    }

    public function __toString()
    {
        return "";
    }

}
