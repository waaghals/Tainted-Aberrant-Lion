<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Instelling implements \JsonSerializable {

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
     * @Column(type="string")
     */
    private $type;  //Internship, Minor, Both

    /**
     * @Column(type="float")
     */
    private $lat;

    /**
     * @Column(type="float")
     */
    private $long;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Stage", mappedBy="instelling", cascade={"remove"})
     */
    private $stages;
    
    
    function __construct() {
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLat() {
        return $this->lat;
    }

    public function getLong() {
        return $this->long;
    }

    public function getStages() {
        return $this->stages;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function setLong($long) {
        $this->long = $long;
    }

    public function setStages($stages) {
        $this->stages = $stages;
    }

    public function addStages($stages) {
        $this->stages->add($stages);
        $stages->setInstelling($this);
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function jsonSerialize() {
        return array(
            "type" => $this->getType(),
            "name" => $this->getNaam(),
            "lat" => $this->getLat(),
            "long" => $this->getLong(),
            "id" => $this->getId(),
            "stages" => $this->getStages()
        );
    }
}

?>
