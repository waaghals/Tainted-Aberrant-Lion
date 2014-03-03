<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class VoorbeeldEntitie1 {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="integer")
     */
    private $INTparameter;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\VoorbeeldEntitie2", inversedBy="OneToOneRelation")
     */
    private $OneToOneRelation;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\VoorbeeldEntitie2", mappedBy="ManyToOneRelation", cascade={"remove"})
     */
    private $OneToManyRelation;

    /**
     * @ManyToMany(targetEntity="\PROJ\Entities\VoorbeeldEntitie2", mappedBy="ManyToManyRelation")
     */
    private $ManyToManyRelation;

    function __construct() {
        $this->OneToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
        $this->ManyToManyRelation = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getManyToManyRelation() {
        return $this->ManyToManyRelation;
    }

    public function setManyToManyRelation($ManyToManyRelation) {
        $this->ManyToManyRelation = $ManyToManyRelation;

        return $this;
    }

    public function addManyToManyRelation($ManyToManyRelation_add) {
        $this->ManyToManyRelation->add($ManyToManyRelation);
        $ManyToManyRelation_add->set_ManyToManyRelation($this);
    }

    public function getOneToManyRelation() {
        return $this->OneToManyRelation;
    }

    public function setOneToManyRelation($OneToManyRelation) {
        $this->OneToManyRelation = $OneToManyRelation;

        return $this;
    }

    public function addOneToManyRelation($OneToManyRelation_add) {
        $this->OneToManyRelation->add($OneToManyRelation);
        $OneToManyRelation_add->set_ManyToOneRelation($this);
    }

    public function getOneToOneRelation() {
        return $this->OneToOneRelation;
    }

    public function setOneToOneRelation($OneToOneRelation) {
        $this->OneToOneRelation = $OneToOneRelation;

        return $this;
    }

    public function getINTparameter() {
        return $this->INTparameter;
    }

    public function setINTparameter($INTparameter) {
        $this->INTparameter = $INTparameter;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

}

?>
