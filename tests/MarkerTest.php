<?php

namespace PROJ\Tests;
use PROJ\Classes\Marker;

class MarkerTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Marker();

        // Act
        $t->setColor("color");
        $t->setSign("sign");
        $t->setTitle("title");
        $t->setHtml("html");
        $t->setLong("long");
        $t->setLat("lat");

        // Assert
        $this->assertEquals("color", $t->getColor());
        $this->assertEquals("sign", $t->getSign());
        $this->assertEquals("title", $t->getTitle());
        $this->assertEquals("html", $t->getHtml());
        $this->assertEquals("long", $t->getLong());
        $this->assertEquals("lat", $t->getLat());
    }

}
?>

