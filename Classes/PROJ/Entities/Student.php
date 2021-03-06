<?php

namespace PROJ\Entities;

/**
 * @Entity
 */
class Student
{

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
    private $city;

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
    private $housenumber;

    /**
     * @Column(type="string", nullable=true)
     */
    private $addition;

    /**
     * @Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @OneToOne(targetEntity="\PROJ\Entities\Account", inversedBy="student")
     */
    private $account;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Project", mappedBy="student", cascade={"remove"})
     */
    private $project;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Institute", mappedBy="creator", cascade={"remove"})
     */
    private $institutes;

    function __construct()
    {
        $this->institutes = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getHousenumber()
    {
        return $this->housenumber;
    }

    public function getAddition()
    {
        return $this->addition;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;
    }

    public function setAddition($addition)
    {
        $this->addition = $addition;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setAccount($account)
    {
        $this->account = $account;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    public function getFullName()
    {
        return sprintf("%s %s", $this->firstname, $this->surname);
    }

    public function getInstitutes()
    {
        return $this->institutes;
    }

    public function setInstitutes($institutes)
    {
        $this->institutes = $institutes;
    }

    public function jsonSerialize()
    {
        return array(
            "addition" => $this->getAddition(),
            "city" => $this->getCity(),
            "email" => $this->getEmail(),
            "firstname" => $this->getFirstname(),
            "housenumber" => $this->getHousenumber(),
            "id" => $this->getId(),
            "street" => $this->getStreet(),
            "surname" => $this->getSurname(),
            "zipcode" => $this->getZipcode(),
            "account" => $this->getAccount()->jsonSerialize()
        );
    }

}

?>
