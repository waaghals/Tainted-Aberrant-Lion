<?php

namespace PROJ\Entities;

require("../Classes/PROJ/Entities/Account.php");

class AccountTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Account();

        // Act
        $t->setUsername("username");
        $t->setPassword("password");

        // Assert
        $this->assertEquals("username", $t->getUsername());
        $this->assertEquals("password", $t->getUsername());
    }

}

?>
