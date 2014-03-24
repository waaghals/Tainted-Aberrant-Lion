<?php
namespace PROJ\Helper;

/**
 * @author Thijs
 */
class SessionHelper {
    public static function secure_session_start() {
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            die("Could not initiate a safe session (ini_set)");
        }
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], false, true);
        session_name('SSID');
        session_start();
        session_regenerate_id();
    }

}
