<?php

namespace Tests\Tools;

use PROJ\Controller\HomeController;

/**
 * Description of Router
 *
 * @author Patrick
 */
class BaseControllerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException PROJ\Exceptions\ServerException
     * @expectedExceptionCode 404
     */
    public function testNonExistingActionInvocation() {
        $c = new HomeController();
        $c->callAction("aHopefullyNeverExitingMethod");
    }

}
