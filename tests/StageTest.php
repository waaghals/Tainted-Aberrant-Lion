<?php

namespace PROJ\Entities;

class StageTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Stage();

        // Act
        $t->setStartdatum("startdatum");
        $t->setEinddatum("einddatum");
        $t->setReview("review");
        $t->setInstelling("instelling");
        $t->setStudent("student");



        // Assert
        $this->assertEquals("startdatum", $t->getStartdatum());
        $this->assertEquals("einddatum", $t->getEinddatum());
        $this->assertEquals("review", $t->getReview());
        $this->assertEquals("instelling", $t->getInstelling());
        $this->assertEquals("student", $t->getStudent());
    }

}

?>
 