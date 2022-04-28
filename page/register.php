<?php
    session_start();
    include ("./module/upload.php");
    require_once "./module/connectDB.php";
    if (isset($_POST['CREATE'])) {

        if(isset($_FILES['pfp'])){
            $IMG_NAME = "undefined";
            $IMG_NAME = Upload($_FILES['pfp'], $_POST);
            if ($IMG_NAME != "undefined") {
                $pathPFP = "./asset/img/user/".$IMG_NAME;
            }
        }
        try {   
            $nom = $_POST['nom'];
            echo $nom;
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $adresse = $_POST['adresse'];
            $hote = 0;
            if (isset($_POST['hote'])) {
                $hote = 1;
            }
            $admin = 0;
            if (isset($_POST['admin'])) {
                $admin = 1;
            }
            

            if (!isset($_SESSION['isAdmin'])) {
                $requete = "INSERT IGNORE INTO Client (Nom, Prenom, Email, Phone, Passwords, Adresse, Hote, PathPFP, Date_Creation, DateModification) VALUES (:nom, :prenom, :email, :phone, :passwords, :adresse, :hote, :pathPFP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                $sendRequete = $db->prepare($requete);
                $sendRequete->bindParam(':nom', $nom, PDO::PARAM_STR);
                $sendRequete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $sendRequete->bindParam(':email', $email, PDO::PARAM_STR);
                $sendRequete->bindParam(':phone', $phone, PDO::PARAM_INT);
                $sendRequete->bindParam(':passwords', $password, PDO::PARAM_STR);
                $sendRequete->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                $sendRequete->bindParam(':hote', $hote, PDO::PARAM_INT);
                $sendRequete->bindParam(':pathPFP', $pathPFP, PDO::PARAM_STR);
                $sendRequete->execute();
                $sendRequete == null;

                $requete = "SELECT * FROM Client where Email = :email and Passwords = :passwords";
                $sendRequete = $db->prepare($requete);
                $sendRequete->bindParam(':email', $email, PDO::PARAM_STR);
                $sendRequete->bindParam(':passwords', $password, PDO::PARAM_STR);
                $sendRequete->execute();
                
                $count = $sendRequete->rowCount();
                $row = $sendRequete->fetch(PDO::FETCH_ASSOC);

                if ($count == 1 && !empty($row)) {
                    $_SESSION['session_open'] = true;
                    $_SESSION['session_email'] = $row["Email"];
                    $_SESSION['isAdmin'] = false;
                    if (isset($row['Admins'])) {
                        $_SESSION['isAdmin'] = true;                        
                    }
                    header("location: /Airbnb/page/home.php");
                    $sendRequete = null;
                    exit();
                }
                else {
                    $msgErr = "Impossible de créer l'utilisateur!";
                }

            }else {
                $requete = "INSERT IGNORE INTO Client (Nom, Prenom, Email, Phone, Passwords, Adresse, Hote, PathPFP, Date_Creation, DateModification, Admins) VALUES (:nom, :prenom, :email, :phone, :passwords, :adresse, :hote, :pathPFP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :admins)";
                $sendRequete = $db->prepare($requete);
                $sendRequete->bindParam(':nom', $nom, PDO::PARAM_STR);
                $sendRequete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $sendRequete->bindParam(':email', $email, PDO::PARAM_STR);
                $sendRequete->bindParam(':phone', $phone, PDO::PARAM_INT);
                $sendRequete->bindParam(':passwords', $password, PDO::PARAM_STR);
                $sendRequete->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                $sendRequete->bindParam(':hote', $hote, PDO::PARAM_INT);
                $sendRequete->bindParam(':admins', $admins, PDO::PARAM_INT);
                $sendRequete->bindParam(':pathPFP', $pathPFP, PDO::PARAM_STR);
                $sendRequete->execute();

                $count = $sendRequete->rowCount();
                $row = $sendRequete->fetch(PDO::FETCH_ASSOC);

                if ($count == 1 && !empty($row)) {
                    $sendRequete = null;
                    $msg = "Utilisateur créer.";
                    exit();
                }
                else {
                    $msgErr = "Impossible de créer l'utilisateur!";
                }
            }
        } catch (PDOException $err) {
            $msgErr = "Une erreur c'est produite: \n $err";
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/style/StyleRegister.css">
    <title>Document</title>
</head>
<body>
    <div class="main">
        <form method="post" enctype="multipart/form-data">
            <h1>Inscription</h1>
            <div class="nom">
                <input type="text" name="nom" placeholder="NOM" required>
            </div>
            <div class="prenom">
                <input type="text" name="prenom" placeholder="PRENOM" required>
            </div>
            <div class="email">
                <input type="mail" name="email" placeholder="EMAIL" required>
            </div>
            <div class="phone">
                <input type="tel" name="phone" placeholder="TÉLÉPHONE" required>
            </div>
            <div class="password">
                <input type="password" name="password" placeholder="MOT DE PASSE" required>
            </div>
            <div class="adresse">
                <input type="text" name="adresse" placeholder="ADRESSE">
            </div>
            <div class="hote">
                <label>HÔTE</label>
                <input type="checkbox" name="hote">
            </div>
            <div class="filePDP">
                <input type="file" name="pfp">
            </div>
            <div class="externe">
                <button class="inscription" type="submit" name="CREATE">CRÉATION DU COMPTE</button>
                <a class="connection" href="/Airbnb/page/login.php">CONNEXION</a>
            </div>
            <?php 
                if (isset($msg)) {
                    echo '<label class="msg">'.$msg.'</label>'; 
                }
                if(isset($msgErr)) {
                    echo '<label class="msgErr">'.$msgErr.'</label>'; 
                    
                }
            ?>
        </form>
    </div>
</body>
</html>