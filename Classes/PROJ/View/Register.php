<?php

namespace PROJ\View;

class Register {

    public function getContent() {
        
        
        return <<<EOD
               <div>
                        <form method="post" action="Checklogin.php">
                                <h2>Please sign in</h2>
                                <input name="username" placeholder="Username" required autofocus />
                                <input name="password" type="password" placeholder="Password" required />
                                <button type="submit">Login</button>
                                <br />
                        </form>
                </div>
EOD;
    }

}

?>