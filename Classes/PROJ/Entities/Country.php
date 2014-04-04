<?php

namespace PROJ\Entities;

/**
 * @Entity(repositoryClass="PROJ\Entities\Repository\CountryRepository")
 */
class Country {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $iso_alpha2;

    /**
     * @Column(type="string")
     */
    private $iso_alpha3;

    /**
     * @Column(type="integer")
     */
    private $iso_numeric;

    /**
     * @Column(type="string")
     */
    private $fips_code;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="string")
     */
    private $capital;

    /**
     * @Column(type="float")
     */
    private $areainsqkm;

    /**
     * @Column(type="integer")
     */
    private $population;

    /**
     * @Column(type="string")
     */
    private $continent;

    /**
     * @Column(type="string")
     */
    private $tld;

    /**
     * @Column(type="string")
     */
    private $currency;

    /**
     * @Column(type="string")
     */
    private $languages;
    
    public function getId() {
        return $this->id;
    }

    public function getIso_alpha2() {
        return $this->iso_alpha2;
    }

    public function getIso_alpha3() {
        return $this->iso_alpha3;
    }

    public function getIso_numeric() {
        return $this->iso_numeric;
    }

    public function getFips_code() {
        return $this->fips_code;
    }

    public function getName() {
        return $this->name;
    }

    public function getCapital() {
        return $this->capital;
    }

    public function getAreainsqkm() {
        return $this->areainsqkm;
    }

    public function getPopulation() {
        return $this->population;
    }

    public function getContinent() {
        return $this->continent;
    }

    public function getTld() {
        return $this->tld;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getLanguages() {
        return $this->languages;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIso_alpha2($iso_alpha2) {
        $this->iso_alpha2 = $iso_alpha2;
    }

    public function setIso_alpha3($iso_alpha3) {
        $this->iso_alpha3 = $iso_alpha3;
    }

    public function setIso_numeric($iso_numeric) {
        $this->iso_numeric = $iso_numeric;
    }

    public function setFips_code($fips_code) {
        $this->fips_code = $fips_code;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setCapital($capital) {
        $this->capital = $capital;
    }

    public function setAreainsqkm($areainsqkm) {
        $this->areainsqkm = $areainsqkm;
    }

    public function setPopulation($population) {
        $this->population = $population;
    }

    public function setContinent($continent) {
        $this->continent = $continent;
    }

    public function setTld($tld) {
        $this->tld = $tld;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function setLanguages($languages) {
        $this->languages = $languages;
    }
}

?>
