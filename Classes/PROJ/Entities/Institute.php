<?php

namespace PROJ\Entities;

use PROJ\DBAL\ApprovalStateType as Status;

/**
 * @Entity
 */
class Institute
{

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
     * @Column(type="institutetype")
     */
    private $type;

    /**
     * @Column(type="float")
     */
    private $lat;

    /**
     * @Column(type="float")
     */
    private $lng;

    /**
     * @Column(type="string")
     */
    private $place;

    /**
     * @Column(type="string")
     */
    private $street;

    /**
     * @Column(type="string")
     */
    private $housenumber;

    /**
     * @Column(type="string")
     */
    private $postalcode;

    /**
     * @Column(type="string")
     */
    private $email;

    /**
     * @Column(type="string")
     */
    private $telephone;

    /**
     * @Column(type="projectstate")
     */
    private $acceptanceStatus = Status::PENDING;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Project", mappedBy="institute", cascade={"remove"})
     */
    private $projects;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Student", inversedBy="institutes")
     */
    private $creator;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Country")
     */
    private $country;

    function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getProjects()
    {
        return $this->projects;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }

    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getApprovedProjects()
    {
        $approvedProjects = array();
        foreach ($this->getProjects() as $project) {
            if ($project->getAcceptanceStatus() === Status::APPROVED) {
                $approvedProjects[] = $project;
            }
        }
        return $approvedProjects;
    }

    public function jsonSerialize()
    {
        return array(
            "type" => ucfirst($this->getType()),
            "name" => $this->getName(),
            "lat" => $this->getLat(),
            "long" => $this->getLng(),
            "id" => $this->getId(),
            "projects" => $this->getProjects(),
            "place" => $this->getPlace(),
            "country" => $this->getCountry()->getName(),
            "street" => $this->getStreet(),
            "housenumber" => $this->getHousenumber(),
            "postalcode" => $this->getPostalcode(),
            "email" => $this->getEmail(),
            "telephone" => $this->getTelephone()
        );
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getHousenumber()
    {
        return $this->housenumber;
    }

    public function getPostalcode()
    {
        return $this->postalcode;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;
    }

    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function getAcceptanceStatus()
    {
        return $this->acceptanceStatus;
    }

    public function setAcceptanceStatus($acceptanceStatus)
    {
        $this->acceptanceStatus = $acceptanceStatus;
    }

}

?>
