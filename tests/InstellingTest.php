<?php

namespace PROJ\Entities;

require("../Classes/PROJ/Entities/Instelling.php");

class InstellingTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Instelling();

        // Act
        $t->setName("name");
        $t->setType("type");
        $t->setLat("lat");
        $t->setLong("long");
        $t->setStages("stages");


        // Assert
        $this->assertEquals("name", $t->getName());
        $this->assertEquals("type", $t->getType());
        $this->assertEquals("lat", $t->getLat());
        $this->assertEquals("long", $t->getLong());
        $this->assertEquals("stages", $t->getStages());
    }

}

?>