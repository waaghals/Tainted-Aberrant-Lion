<?php

namespace PROJ\Entities;

/**
 * @Entity
 */
class Recht
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ManyToMany(targetEntity="\PROJ\Entities\RightGroup", inversedBy="rights")
     */
    private $rightgroups;

    function __construct()
    {
        $this->rightgroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRightgroups()
    {
        return $this->rightgroups;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRightgroups($rightgroups)
    {
        $this->rightgroups = $rightgroups;
    }

    public function addRightGroup($group)
    {
        $this->rightgroups->add($group);
        $group->__DNUaddRight($this);
    }

    public function __DNUaddRightGroup($group)
    {
        $this->rightgroups->add($group);
    }

}

?>
