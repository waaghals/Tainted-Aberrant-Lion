<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Stage {

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
     * @OneToOne(targetEntity="\PROJ\Entities\Review", mappedBy="stage", cascade={"remove"})
     */
    private $review;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Instelling", inversedBy="stages")
     */
    private $institute;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Student", inversedBy="stage")
     */
    private $student;

    function __construct() {
        $this->OneToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
        $this->ManyToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getStartdate() {
        return $this->startedate;
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

    public function setStartdate($startdate) {
        $this->startdate = $startdate;
    }

    public function setEnddate($enddate) {
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



}

?>
