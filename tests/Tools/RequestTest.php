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
        $this->r = new Request();
    }

    public function testGoodController() {
        $this->assertEquals($this->r->getController(), "homeController");
    }

    public function testGoodAction() {
        $this->assertEquals($this->r->getAction(), "indexAction");
    }

    public function testGoodArguments() {
        $this->assertEquals($this->r->getArgument("id"), 1);
        $this->assertEquals($this->r->getArgument("test"), "good");
    }

}
