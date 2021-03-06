<?php

namespace PROJ\Entities;

use PROJ\DBAL\ApprovalStateType as Status;

/**
 * @Entity
 */
class Project
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="date")
     */
    private $startdate;

    /**
     * @Column(type="date")
     */
    private $enddate;

    /**
     * @Column(type="projecttype")
     */
    private $type;

    /**
     * @Column(type="projectstate")
     */
    private $acceptanceStatus = Status::PENDING;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Review", mappedBy="project", cascade={"remove"})
     */
    private $review;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Institute", inversedBy="projects")
     */
    private $institute;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Student", inversedBy="project")
     */
    private $student;

    public function getId()
    {
        return $this->id;
    }

    public function getStartdate()
    {
        return $this->startdate;
    }

    public function getEnddate()
    {
        return $this->enddate;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getInstitute()
    {
        return $this->institute;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setStartdate($startdatum)
    {
        $this->startdate = $startdatum;
    }

    public function setendDate($enddate)
    {
        $this->enddate = $enddate;
    }

    public function setReview($review)
    {
        $this->review = $review;
    }

    public function setInstitute($institute)
    {
        $this->institute = $institute;
    }

    public function setStudent($student)
    {
        $this->student = $student;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function isApprovedInstitute()
    {
        if ($this->getInstitute()->getAcceptanceStatus() === Status::APPROVED) {
            return $this->getInstitute();
        }
        return null;
    }

    public function isApprovedReview()
    {
        if ($this->getReview()->getAcceptanceStatus() === Status::APPROVED) {
            return $this->getReview();
        }
        return null;
    }

    public function jsonSerialize()
    {
        $return = array(
            "id" => $this->getId(),
            "author" => $this->getStudent(),
            "start_year" => $this->getStartdate()->Format("Y"),
            "start_month" => $this->getStartdate()->Format("n"),
            "end_year" => $this->getEnddate()->Format("Y"),
            "end_month" => $this->getEnddate()->Format("n"),
            "type" => ucfirst($this->getType())
        );

        if ($this->getReview() != null) {
            $return["review"] = $this->getReview();
        }
        if ($this->getInstitute() != null) {
            $return["institute"] = $this->getInstitute()->jsonSerialize();
        }

        return $return;
    }

    public function getAcceptanceStatus()
    {
        return $this->acceptanceStatus;
    }

    public function setAcceptanceStatus($approved)
    {
        $this->acceptanceStatus = $approved;
    }

}
