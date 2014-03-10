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
     * @OneToOne(targetEntity="\PROJ\Entities\Internship", inversedBy="review")
     */
    private $internship;

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

    public function getInternship() {
        return $this->internship;
    }
    
    public function setText($text) {
        $this->text = $text;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setInternship($internship) {
        $this->internship = $internship;
    }

}

?>
