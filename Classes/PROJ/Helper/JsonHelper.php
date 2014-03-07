<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Helper;

/**
 * Description of JsonHelper
 *
 * @author Patrick
 */
class JsonHelper {

    /**
     * Check if a given string is valid json
     * @param string $json
     * @return boolean
     */
    public static function isJson($json) {
        return ((is_string($json) &&
                (is_object(json_decode($json)) ||
                is_array(json_decode($json))))) ? true : false;
    }

}
