<?php

namespace PROJ\Controller;
use PROJ\Exceptions;
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
        try {
             $reflection = new \ReflectionMethod($this, $actionName);
        } catch (\Exception $e) {
            $msg = sprintf("Action \"%s\" does not exist.", $actionName);
            throw new Exceptions\ServerException($msg, Exceptions\ServerException::NOT_FOUND);
        }

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
