<?php

namespace PROJ\Tools;
use PROJ\Exceptions;
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
        if(!is_a($req, "\PROJ\Tools\Request")){
            throw new \InvalidArgumentException("Router::Match did not receive a valid request object");
        }
        
        $controllerPath = sprintf("PROJ\Controllers\%s", $req->getController());
        
        /*
         * can't catch the exception from the ReflectionClass because the
         * Autoloader tries to load first and fails which already raises
         * a fatal error.
         * 
         * Try to load it ourself first, on failure throw a ServerException
         * 
         * Add Classes/ prefix, this is the folder the autoloader works in.
         */
         if(!file_exists("Classes/" . $controllerPath . ".php")) {
               $msg = sprintf("Controller \"%s\" doesn't exists", $req->getController());
               throw new Exceptions\ServerException($msg, Exceptions\ServerException::NOT_FOUND); 
         }
            
        $ref =  new \ReflectionClass($controllerPath);

        if(!$ref->isSubclassOf("\PROJ\Controllers\BaseController")){
            $msg = sprintf("Controller \"%s\" isn't a valid controller.", $req->getController());
            throw new Exceptions\ServerException($msg, Exceptions\ServerException::SERVER_ERROR);
        }
        
        $controller = $ref->newInstance();
        $controller->callAction($req->getAction(), $req->getArguments());
    }

}
