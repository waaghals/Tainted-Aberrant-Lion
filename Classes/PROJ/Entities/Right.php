<?php

namespace PROJ\Entities;

/**
 * @Entity
 */
class Right
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

}

?>
