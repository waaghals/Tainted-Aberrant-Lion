<?php

namespace PROJ\Entities;

/**
 * @Entity
 */
class RightGroup
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
     * @ManyToMany(targetEntity="\PROJ\Entities\Recht", mappedBy="rightgroups", cascade={"remove"})
     */
    private $rights;

    /**
     * @OneToMany(targetEntity="\PROJ\Entities\Account", mappedBy="rightgroup", cascade={"remove"})
     */
    private $accounts;

    function __construct()
    {
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRights()
    {
        return $this->rights;
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRights($rights)
    {
        $this->rights = $rights;
    }

    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }

    public function addRight($right)
    {
        $this->rights->add($right);
        $right->__DNUaddRightGroup($this);
    }

    public function __DNUaddRight($right)
    {
        $this->rights->add($right);
    }

}

?>
