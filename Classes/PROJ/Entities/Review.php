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
     * @ManyToOne(targetEntity="\PROJ\Entities\Stage", inversedBy="reviews")
     */
    private $stage;

    function __construct() {
        $this->OneToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
        $this->ManyToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getStudent() {
        return $this->student;
    }

    public function getInstelling() {
        return $this->instelling;
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

    public function setStudent($student) {
        $this->student = $student;
    }

    public function setInstelling($instelling) {
        $this->instelling = $instelling;
    }

    public function setStage($stage) {
        $this->stage = $stage;
    }

}

?>
