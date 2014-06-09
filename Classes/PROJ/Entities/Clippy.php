<?php

namespace PROJ\Entities;

/**
 * Description of Clippy
 *
 * @author Sebastian
 */

/**
 * @Entity
 */
class Clippy
{

    /**
     * @Id @Column(type="string")
     */
    private $controller;

    /**
     * @Id @Column(type="string")
     */
    private $action;

    /**
     * @Column(type="string")
     */
    private $description;

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
