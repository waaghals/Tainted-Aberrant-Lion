<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Stage implements \JsonSerializable{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="date")
     */
    private $startdatum;

    /**
     * @Column(type="date")
     */
    private $einddatum;

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
    private $instelling;

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

    public function getStartdatum() {
        return $this->startdatum;
    }

    public function getEinddatum() {
        return $this->einddatum;
    }

    public function getReview() {
        return $this->review;
    }

    public function getInstelling() {
        return $this->instelling;
    }

    public function getStudent() {
        return $this->student;
    }

    public function setStartdatum($startdatum) {
        $this->startdatum = $startdatum;
    }

    public function setEinddatum($einddatum) {
        $this->einddatum = $einddatum;
    }

    public function setReview($review) {
        $this->review = $review;
    }

    public function setInstelling($instelling) {
        $this->instelling = $instelling;
    }

    public function setStudent($student) {
        $this->student = $student;
    }

    public function jsonSerialize() {
        return $this;
    }

}

?>
