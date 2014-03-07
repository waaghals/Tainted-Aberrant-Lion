<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Tools;

/**
 * Description of Request
 *
 * @author Patrick
 */
class Request {

    private $controller;
    private $action;
    private $arguments;

    public function __construct() {
        $parts = \explode('/', $_SERVER['REQUEST_URI']);

        //Calls isValidPart and removes part when it isValidPart returns false
        $parts = \array_filter($parts, "isValidPart");

        //Get the controller from the first part, action from the second.
        //Default to index for controller and method
        $this->controller = ($c = array_shift($parts)) ? $c : 'index';
        $this->action = ($c = array_shift($parts)) ? $c : 'index';

        $this->arguments = array();

        if (is_array($parts)) {
            foreach ($parts as $part) {
                list($key, $value) = explode("=", $part);

                //Ignore any keys that were already present in the uri
                if (!isset($this->arguments[$key])) {
                    $this->arguments[$key] = array();
                }
            }
        }
    }

    /**
     * Checks if the part from the uri is valid
     * @param string $part
     * @return boolean False when the part is not valid
     */
    private function isValidPart($part) {
        //TODO think of nice validation rules.
        return true;
    }

    public function getController() {
        return $this->controller . "Controller";
    }

    public function getAction() {
        return $this->action . "Action";
    }

    /**
     * Get a uri argument by key
     * @param string $key
     * @return string Value if key exits, false otherwise
     */
    public function getArgument($key) {
        if (isset($this->arguments[$key])) {
            return $this->arguments[$key];
        }
        return false;
    }

}
