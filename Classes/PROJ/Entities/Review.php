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
     * @OneToOne(targetEntity="\PROJ\Entities\Project", inversedBy="review")
     */
    private $project;

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getProject() {
        return $this->project;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setProject($project) {
        $this->project = $project;
    }

}

?>
