<?php

namespace PROJ\View;

class Login {
    private $loginError = null;

    public function getContent() {
        $r = null;
        if($this->loginError != null)
            $r .= "<b>".$this->loginError."</b><br><br>";
        
        $r .= "<form name='login' action='/Login/' method='post'>"
                . "<div class='login_left_col'>"
                . "Username:"
                . "</div>"
                . "<div class='login_right_col'>"
                . "     <input type='text' name='username'>"
                . "</div>"
                . "<div class='login_left_col'>"
                . "Password:"
                . "</div>"
                . "<div class='login_right_col'>"
                . "     <input type='password' name='password'>"
                . "</div>"
                . "<div class='login_left_col'>"
                . "</div>"
                . "<div class='login_right_col'>"
                . "     <input type='submit' name='loginBTN'>"
                . "</div>"
            . "</form>";
        
        return $r;
    }
    
    public function setLoginError($loginError) {
        $this->loginError = $loginError;
    }

}

?>