<?php

namespace PROJ\Controller;

/**
 * Description of baseController
 *
 * @author Patrick
 */
abstract class BaseController {

    /**
     * Call a controller action with named arguments.
     * @param string $actionName
     * @param array $arguments
     * @return mixed value of the called method
     */
    public function callAction($actionName, array $arguments = array()) {
        $reflection = new \ReflectionMethod($this, $actionName);
        $pass = array();

        //Build the arguments array in the order of actual method arguments
        foreach ($reflection->getParameters() as $param) {
            $key = $param->getName();

            if (isset($arguments[$key])) {
                $pass[] = $arguments[$key];
            } else {
                $pass[] = $param->getDefaultValue();
            }
        }

        //Actually run the method/action
        return $reflection->invokeArgs($this, $pass);
    }

}
