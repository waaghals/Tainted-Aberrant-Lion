<?php

namespace PROJ\Controller;

use PROJ\Exceptions\ServerException;

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
            throw new ServerException($msg, ServerException::NOT_FOUND);
        }

        $pass = array();

        //Build the arguments array in the order of actual method arguments
        foreach ($reflection->getParameters() as $param) {
            $key = $param->getName();

            if (isset($arguments[$key])) {
                $pass[] = $arguments[$key]; //Named argument is set, use it.
            } elseif (!$param->isOptional()) {
                $msg = sprintf("Missing non optional parameter for argument: %s", $key);
                throw new ServerException($msg, ServerException::BAD_REQUEST);
            } else {
                $pass[] = $param->getDefaultValue(); //Use the default value
            }
        }

        //Actually run the method/action
        return $reflection->invokeArgs($this, $pass);
    }

}
