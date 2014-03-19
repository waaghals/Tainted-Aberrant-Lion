<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Review {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="text")
     */
    private $text;

    /**
     * @Column(type="integer")
     */
    private $rating;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Stage", inversedBy="review")
     */
    private $stage;

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getStage() {
        return $this->stage;
    }
    
    public function setText($text) {
        $this->text = $text;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setStage($stage) {
        $this->stage = $stage;
    }

}

?>
