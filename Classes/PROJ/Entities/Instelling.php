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

    public function getId() {
        return $this->id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

}

?>
