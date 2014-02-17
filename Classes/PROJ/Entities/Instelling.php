<?php

namespace PROJ\Entities;

//TODO: School & Bedrijf over-erven van Instelling.

/**
 * @Entity 
 */
class Instelling {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $naam;

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

    public function getId() {
        return $this->id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
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

}

?>
