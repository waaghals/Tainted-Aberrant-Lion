<?php

namespace PROJ\Entities;

class StudentTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Student();

        // Act
        $t->setVoornaam("voornaam");
        $t->setAchternaam("achternaam");
        $t->setWoonplaats("woonplaats");
        $t->setPostcode("postcode");
        $t->setStraat("straat");
        $t->setHuisnummer("huisnummer");
        $t->setToevoeging("toevoeging");


        // Assert
        $this->assertEquals("voornaam", $t->getVoornaam());
        $this->assertEquals("achternaam", $t->getAchternaam());
        $this->assertEquals("woonplaats", $t->getWoonplaats());
        $this->assertEquals("postcode", $t->getPostcode());
        $this->assertEquals("straat", $t->getStraat());
        $this->assertEquals("huisnummer", $t->getHuisnummer());
        $this->assertEquals("toevoeging", $t->getToevoeging());
    }

}

?>
