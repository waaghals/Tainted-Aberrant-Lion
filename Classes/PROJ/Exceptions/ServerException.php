<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Exceptions;

/**
 * Description of ServerException
 *
 * @author Patrick
 */
class ServerException extends \Exception
{
    const SERVER_ERROR  = 500;
    const NOT_FOUND     = 404;
    //TODO add more when needed
    
    /**
     * Custom server error exception
     * @param type $message
     * @param type $code
     * @param \PROJ\Exceptions\Exception $previous
     * @throws Exception
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        
        parent::__construct($message, $code, $previous);
        
        if(!($code == self::NOT_FOUND || $code == self::SERVER_ERROR)) {
            throw new \Exception("Not a valid status code for ServerException. ");
        }
    }
}
