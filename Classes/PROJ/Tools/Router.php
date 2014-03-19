<?php

namespace PROJ\Tools;

use PROJ\Exceptions;
use Doctrine\Common\ClassLoader;

/**
 * Splits the uri and calls the correct controller and action
 *
 * @author Patrick
 */
class Router {

    /**
     * Match the request data agains a controller and invoke the action
     * @param \PROJ\Tools\Request $req
     */
    public static function match($req) {
        if (!is_a($req, "\PROJ\Tools\Request")) {
            throw new \InvalidArgumentException("Router::Match did not receive a valid request object");
        }

        $controllerPath = sprintf("PROJ\Controllers\%s", $req->getController());

        /*
         * Find the autoloader responsible for the controller. If the autoloader
         * doesn't exists it means the controller doesn't exists.
         */
        $classLoader = ClassLoader::getClassLoader($controllerPath);
        if ($classLoader == null) {
            $msg = sprintf("Controller \"%s\" doesn't exists", $req->getController());
            throw new Exceptions\ServerException($msg, Exceptions\ServerException::NOT_FOUND);
        }

        $ref = new \ReflectionClass($controllerPath);

        if (!$ref->isSubclassOf("\PROJ\Controllers\BaseController")) {

            $msg = sprintf("Controller \"%s\" isn't a valid controller.", $req->getController());
            throw new Exceptions\ServerException($msg, Exceptions\ServerException::SERVER_ERROR);
        }

        $controller = $ref->newInstance();
        $controller->callAction($req->getAction(), $req->getArguments());
    }

}
