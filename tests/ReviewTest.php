<?php

namespace PROJ\Entities;

class ReviewTest extends \PHPUnit_Framework_TestCase {

    public function test() {
        // Arrange
        $t = new Review();

        // Act
        $t->setText("text");
        $t->setRating("rating");
        $t->setStage("stage");


        // Assert
        $this->assertEquals("text", $t->getText());
        $this->assertEquals("rating", $t->getRating());
        $this->assertEquals("stage", $t->getStage());
    }

}

?>