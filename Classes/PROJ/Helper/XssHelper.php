<?php
namespace PROJ\Helper;

/**
 * @author Thijs
 */
class XssHelper {
    public static function sanitizeInput($input) {
        return strip_tags(htmlentities($input, ENT_QUOTES));
    }
}
