<?php

namespace PROJ\Views;

class Register {

    public function getContent() {
        
        
        return <<<EOD

    <div>
         <form method="post" class="center">
                 <h2>Please register</h2>
                 <input name="username" maxlength="50" placeholder="Username" required autofocus /> <br />
                 <input name="password" maxlength="50" type="password" placeholder="Password" required /> <br />
                 <input name="passwordagain" maxlength="50" type="password" placeholder="Password repeat" required /> <br />
                 <input name="firstname" maxlength="50" placeholder="Firstname" required /> <br />
                 <input name="surname" maxlength="50" placeholder="surname" required /> <br />
                 <input name="city" maxlength="50" placeholder="City" required /> <br />
                 <input name="zipcode" maxlength="6" placeholder="Zipcode" required /> <br />
                 <input name="street" maxlength="50" placeholder="Street" required /> <br />
                 <input name="streetnumber" type="number" value="1" required /> <br />
                 <input name="addition" maxlength="3" placeholder="addition" /> <br />
                 <button type="submit">Register</button>
         </form>
    </div>
EOD;
    }
    
    public function getErrorContent($error){
        return <<<EOT
    <div class="alert">
        <p> $error </p>
    </div>
EOT;
    }

}

?>