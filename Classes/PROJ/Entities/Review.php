<?php

namespace PROJ\Entities;

use PROJ\DBAL\ApprovalStateType as Status;

/**
 * @Entity
 */
class Review
{

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
    private $assignmentrating;

    /**
     * @Column(type="integer")
     */
    private $guidancerating;

    /**
     * @Column(type="integer")
     */
    private $accommodationrating;

    /**
     * @Column(type="integer")
     */
    private $rating;

    /**
     * @Column(type="projectstate")
     */
    private $approved = Status::PENDING;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Project", inversedBy="review")
     */
    private $project;

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAssignmentRating()
    {
        return $this->assignmentrating;
    }

    public function getGuidanceRating()
    {
        return $this->guidancerating;
    }

    public function getAccommodationRating()
    {
        return $this->accommodationrating;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setAssignmentRating($rating)
    {
        $this->assignmentrating = $rating;
    }

    public function setGuidanceRating($rating)
    {
        $this->guidancerating = $rating;
    }

    public function setAccommodationRating($rating)
    {
        $this->accommodationrating = $rating;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

}

?>
