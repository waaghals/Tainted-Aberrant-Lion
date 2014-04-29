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
     * @Column(type="projectstate")
     */
    private $approved = Status::PENDING;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Project", mappedBy="institute", cascade={"remove"})
     */
    private $projects;

    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\Student", inversedBy="institutes")
     */
    private $creator;

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

    public function jsonSerialize()
    {
        return array(
            "type" => $this->getType(),
            "name" => $this->getName(),
            "lat" => $this->getLat(),
            "long" => $this->getLong(),
            "id" => $this->getId(),
            "projects" => $this->getProjects()
        );
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

}

?>
