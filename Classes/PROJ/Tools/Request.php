<?php

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
        $this->arguments = array();
        $uri = trim($_SERVER['REQUEST_URI'], "/"); //Remove slashes
        $parts = \explode('/', $uri);

        //Calls isValidPart and removes part when it isValidPart returns false
        $cleanParts = \array_filter($parts, array($this, "isValidPart"));
        $this->parseParts($cleanParts);
    }
    
    /**
     * Parse the parts in a controller, action and any arguments remaining.
     * @param array $parts
     */
    private function parseParts($parts) {
        //Get the controller from the first part, action from the second.
        //Default to home for controller and index for action.     
        $this->controller = ($c = array_shift($parts)) ? $c : 'home';
        $this->action = ($a = array_shift($parts)) ? $a : 'index';
        if (is_array($parts)) {
            foreach ($parts as $part) {
                list($key, $value) = explode("=", $part);

                //Ignore any keys that were already present in the uri
                if (!isset($this->arguments[$key])) {
                    $this->arguments[$key] = $value;
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
        if($part == trim(Config::BASEPATH, "/")) {
            return false;
        }
        return true;
    }

    public function getController() {
        return $this->controller . "Controller";
    }

    public function getAction() {
        return $this->action . "Action";
    }
    
    public function getArguments() {
        return $this->arguments;
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
