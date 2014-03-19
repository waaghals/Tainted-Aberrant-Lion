<?php

namespace Tests\Tools;

use PROJ\Tools\Request;

/**
 *
 * @author Patrick
 */
class RequestTest extends \PHPUnit_Framework_TestCase {

    private $r;

    public function setUp() {
        $_SERVER['REQUEST_URI'] = "/home/index/id=1/test=good/";
    }

    public function testGoodController() {
        $this->r = new Request();
        $this->assertEquals($this->r->getController(), "homeController");
    }

    public function testGoodAction() {
        $this->r = new Request();
        $this->assertEquals($this->r->getAction(), "indexAction");
    }

    public function testGoodArguments() {
        $this->r = new Request();
        $this->assertEquals($this->r->getArgument("id"), 1);
        $this->assertEquals($this->r->getArgument("test"), "good");
    }

    /**
     * @expectedException PROJ\Exceptions\ServerException
     */
    public function testMissinDuplicateParameter() {
        $_SERVER['REQUEST_URI'] = "/test/nonOptionalParameter/test=1/test=2/";
        $this->r = new Request();
    }

    /**
     * @expectedException PROJ\Exceptions\ServerException
     */
    public function testMissinEqualsSignParameter() {
        $_SERVER['REQUEST_URI'] = "/test/nonOptionalParameter/test/";
       $this->r = new Request();
    }

}
