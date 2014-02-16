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
     * @Column(type="text")
     */
    private $instelling;

    /**
     * @Column(type="integer")
     */
    private $student;

    /**
     * @Column(type="date")
     */
    private $startdatum;

    /**
     * @Column(type="date")
     */
    private $einddatum;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Review", mappedBy="stage", cascade={"remove"})
     */
    private $reviews;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Student", mappedBy="stage", cascade={"remove"})
     */
    private $studenten;

    function __construct() {
        $this->OneToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
        $this->ManyToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId() {
        return $this->id;
    }

    public function getInstelling() {
        return $this->instelling;
    }

    public function getStudent() {
        return $this->student;
    }

    public function setInstelling($instelling) {
        $this->instelling = $instelling;
    }

    public function setStudent($student) {
        $this->student = $student;
    }

    public function getStartdatum() {
        return $this->startdatum;
    }

    public function getEinddatum() {
        return $this->einddatum;
    }

    public function setStartdatum($startdatum) {
        $this->startdatum = $startdatum;
    }

    public function setEinddatum($einddatum) {
        $this->einddatum = $einddatum;
    }

}

?>
