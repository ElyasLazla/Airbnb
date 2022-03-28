<?php 
        session_start();
        session_destroy();
        if (isset($_SESSION["seesion_open"])) {
                if (session_abort()) {
                        header("location: /Airbnb/page/login.php");
                }
                else{
                        echo "impossible de détruire la session";
                        die();
                }
                
        }
        else {
                header("location: /Airbnb/page/login.php");
        }
    