<?php
    try {
        $db = new PDO('mysql:host=185.31.40.32:3306;dbname=elyas-lazla_airbnb', "250295", "StarWars2003?");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $err) {
        $e = $err->getMessage();
        echo "Impossible de se connecter au serveur: $e";
        die();
    }
?>