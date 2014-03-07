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
            throw new \Exception("Router::Match did not receive a valid request");
        }
        
        $controllerPath = sprintf("PROJ\Controller\%s", $req->getController());
        $ref =  new \ReflectionClass($controllerPath);
        if(!$ref->isSubclassOf("\PROJ\Controller\BaseController")){
            throw new Exceptions\ServerException("Invalid controller. Got: " . $ref->getParentClass(), Exceptions\ServerException::SERVER_ERROR);
        }
        
        $controller = $ref->newInstance();
        $controller->callAction($req->getAction(), $req->getArguments());

        /* if(!is_callable(array($controller,$action))) {
          $message = sprintf("File %s/%s does not exist.", $controller, $action);
          throw new ServerException($message, ServerException::NOT_FOUND);
          }
         */
    }

}
