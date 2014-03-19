<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Institute implements \JsonSerializable {

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
     * @OneToMany(targetEntity="\PROJ\Entities\Project", mappedBy="institute", cascade={"remove"})
     */
    private $projects;
    
    
    function __construct() {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection;
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

    public function getProjects() {
        return $this->projects;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function setLong($long) {
        $this->long = $long;
    }

    public function setProjects($projects) {
        $this->projects = $projects;
    }

    public function addProjects($projects) {
        $this->projects->add($projects);
        $projects->setInstitute($this);
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
            "name" => $this->getName(),
            "lat" => $this->getLat(),
            "long" => $this->getLong(),
            "id" => $this->getId(),
            "projects" => $this->getProjects()
        );
    }
}

?>
