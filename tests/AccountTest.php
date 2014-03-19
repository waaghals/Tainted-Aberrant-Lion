<?php

namespace PROJ\Tests;
use PROJ\Entities\Account;

class AccountTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Account();

        // Act
        $t->setUsername("username");
        $t->setPassword("password");

        // Assert
        $this->assertEquals("username", $t->getUsername());
        $this->assertEquals("password", $t->getPassword());
    }

}

?>
