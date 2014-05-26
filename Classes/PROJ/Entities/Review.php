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
    private $acceptanceStatus = Status::PENDING;

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

    public function getAcceptanceStatus()
    {
        return $this->acceptanceStatus;
    }

    public function setAcceptanceStatus($acceptanceStatus)
    {
        $this->acceptanceStatus = $acceptanceStatus;
    }

    public function getApprovedProject()
    {
        if ($this->getProject()->acceptanceStatus === Status::APPROVED) {
            return $this->getProject();
        }
        return null;
    }

    public function jsonSerialize()
    {
        return array(
            "text"                => $this->getText(),
            "assignmentrating"    => $this->getAssignmentRating(),
            "guidancerating"      => $this->getGuidanceRating(),
            "accommodationrating" => $this->getAccommodationRating(),
            "rating"              => $this->getRating(),
            "project"             => $this->getApprovedProject()->jsonSerialize()
        );
    }

}
