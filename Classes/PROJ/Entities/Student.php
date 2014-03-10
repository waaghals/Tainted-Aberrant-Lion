<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Student {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $voornaam;

    /**
     * @Column(type="string")
     */
    private $achternaam;

    /**
     * @Column(type="string")
     */
    private $woonplaats;

    /**
     * @Column(type="string")
     */
    private $postcode;

    /**
     * @Column(type="string")
     */
    private $straat;

    /**
     * @Column(type="integer")
     */
    private $huisnummer;

    /**
     * @Column(type="string", nullable=true)
     */
    private $toevoeging;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Account", inversedBy="student")
     */
    private $account;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Stage", mappedBy="student", cascade={"remove"})
     */
    private $stage;

    public function getId() {
        return $this->id;
    }

    public function getVoornaam() {
        return $this->voornaam;
    }

    public function getAchternaam() {
        return $this->achternaam;
    }

    public function getWoonplaats() {
        return $this->woonplaats;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function getStraat() {
        return $this->straat;
    }

    public function getHuisnummer() {
        return $this->huisnummer;
    }

    public function getToevoeging() {
        return $this->toevoeging;
    }

    public function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    public function setAchternaam($achternaam) {
        $this->achternaam = $achternaam;
    }

    public function setWoonplaats($woonplaats) {
        $this->woonplaats = $woonplaats;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function setStraat($straat) {
        $this->straat = $straat;
    }

    public function setHuisnummer($huisnummer) {
        $this->huisnummer = $huisnummer;
    }

    public function setToevoeging($toevoeging) {
        $this->toevoeging = $toevoeging;
    }
    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
    }


}

?>
