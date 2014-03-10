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
    private $firstname;

    /**
     * @Column(type="string")
     */
    private $surname;

    /**
     * @Column(type="string")
     */
    private $place;

    /**
     * @Column(type="string")
     */
    private $zipcode;

    /**
     * @Column(type="string")
     */
    private $street;

    /**
     * @Column(type="integer")
     */
    private $houseNumber;

    /**
     * @Column(type="string")
     */
    private $additation;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Account", inversedBy="student")
     */
    private $account;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Internship", mappedBy="student", cascade={"remove"})
     */
    private $internship;

    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getPlace() {
        return $this->place;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getStreet() {
        return $this->street;
    }

    public function gethouseNumber() {
        return $this->houseNumber;
    }

    public function getAdditation() {
        return $this->additation;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function sethouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;
    }

    public function setAdditation($additation) {
        $this->additation = $additation;
    }

}

?>
