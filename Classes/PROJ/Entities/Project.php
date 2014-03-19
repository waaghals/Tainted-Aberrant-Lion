<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Project implements \JsonSerializable {

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
     * @Column(type="string")
     */
    private $type;

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

    public function getId() {
        return $this->id;
    }

    public function getStartdate() {
        return $this->startdate;
    }

    public function getEnddate() {
        return $this->enddate;
    }

    public function getReview() {
        return $this->review;
    }

    public function getInstitute() {
        return $this->institute;
    }

    public function getStudent() {
        return $this->student;
    }

    public function setStartdate($startdatum) {
        $this->startdate = $startdatum;
    }

    public function setendDate($enddate) {
        $this->enddate = $enddate;
    }

    public function setReview($review) {
        $this->review = $review;
    }

    public function setInstitute($institute) {
        $this->institute = $institute;
    }

    public function setStudent($student) {
        $this->student = $student;
    }

    public function jsonSerialize() {
        return array(
            
            "review" => $this->getReview(),
            "author" => $this->getStudent()
        );
    }

}

?>
