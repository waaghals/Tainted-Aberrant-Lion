<?php
namespace Tests\Exceptions;
use PROJ\Exceptions\ServerException;
/**
 * Description of ServerExceptionTest
 *
 * @author Patrick
 */
class ServerExceptionTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not a valid status code for ServerException.
     */
    public function testWrongExceptionCode() {
        throw new ServerException("Example server exception.", -1);
    }
}
