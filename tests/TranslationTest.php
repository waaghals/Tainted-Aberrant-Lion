<?php

namespace PROJ\Tests;

use PROJ\Services\TranslationService;

class TranslationTest extends \PHPUnit_Framework_TestCase
{

    public $dummydata;
    public $service;

    public function __construct()
    {
        // $this->ResetData();
        $this->service = new TranslationService();
    }

    public function ResetData()
    {
        $this->dummydata['keys'] = array("first_name");
    }

    public function testTranslationTranslateSuccess()
    {
        $this->ResetData();
        
        $translate = $this->service->translateAll($this->dummydata["keys"]);

        $this->assertEquals($translate["first_name"], "First name");
    }

    public function __toString()
    {
        return "";
    }

}
