<?php

namespace Tests\Tools;

use PROJ\Tools\Router;

/**
 * Description of Router
 *
 * @author Patrick
 */
class RouterTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        $_SERVER['REQUEST_URI'] = "/";
    }

    /**
     * @expectedException ReflectionException
     */
    public function testGoodController() {

        $existingController = "HomeController";
        $requestMock = $this->getMock("\PROJ\Tools\Request");

        $requestMock->expects($this->any())
                ->method("getController")
                ->will($this->returnValue($existingController));

        $method = array('callAction', 'newInstance');
        $args = array($existingController);


        $reflectionMock = $this->getMock("\ReflectionClass", $method, $args);

        $reflectionMock->expects($this->once())
                ->method("newInstance")
                ->will($this->returnValue(new $existingController));

        $reflectionMock->expects($this->once())
                ->method("callAction")
                ->will($this->returnValue(true));

        Router::match($requestMock);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidRequestException() {
        Router::match(new \stdClass());
    }

    /**
     * @expectedException PROJ\Exceptions\ServerException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage Controller "FailController" isn't a valid controller.
     */
    /*
      public function testInvalidControllerWithoutBaseController() {
      $mock = $this->getMock("\PROJ\Tools\Request", array("getController"));

      $mock->expects($this->any())
      ->method("getController")
      ->will($this->returnValue("FailController"));
      Router::match($mock);
      }

     */

    /**
     * @expectedException PROJ\Exceptions\ServerException
     * @expectedExceptionCode 404
     */
    public function testNonExistingController() {
        $mock = $this->getMock("\PROJ\Tools\Request");

        $mock->expects($this->any())
                ->method("getController")
                ->will($this->returnValue("thisControllerDoesntExistController"));

        Router::match($mock);
    }

}
