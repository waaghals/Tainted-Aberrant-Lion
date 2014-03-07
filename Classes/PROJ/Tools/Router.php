<?php

namespace PROJ\Tools;

/**
 * Splits the uri and calls the correct controller and action
 *
 * @author Patrick
 */
class Router {

    private $req;

    function __construct(Request $request) {
        $this->req = $request;
        
    }

    function match() {
        
    }
    
    

}
