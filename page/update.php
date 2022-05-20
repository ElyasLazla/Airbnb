<?php
    include ("./module/upload.php");
    require_once "./module/connectDB.php";
    $CheckBoxHote = 0;
    $CheckBoxAdmin = 0;
    session_start();
    if (!isset($_SESSION["session_open"])) {
        header("location: /Airbnb/page/login.php");
        exit();
    }

    $id = $_GET["id"];
    if (isset($_REQUEST['UPDATES'])) {
        if (!isset($_SESSION["session_open"])) {
            header("location: /Airbnb/page/login.php");
            exit();
        }
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $adresse = $_POST["adresse"];

        if(isset($_FILES['pfp'])){
            $IMG_NAME = "undefined";
            $IMG_NAME = Upload($_FILES['pfp'], $_POST);
            if ($IMG_NAME != "undefined") {
                $pathPFP = "./asset/img/user/".$IMG_NAME;
            }
        }
        echo $pathPFP;
        $admin = 0;
        if (isset($_POST["admin"])) {
            $admin = 1;
        }
        $hote = 0;
        if (isset($_POST["hote"])) {
            $hote = 1;
        }

        try {
            $sqlUpdate = "UPDATE Client SET Nom=:nom, Prenom=:prenom, Email=:email, Phone=:phone, Passwords=:password, Adresse=:adresse, Hote=:hote, DateModification=CURRENT_TIME(), Admins=:admin, PathPFP=:pathPFP WHERE ID=:id";
            $sendRequeteUpdate = $db->prepare($sqlUpdate);
            $sendRequeteUpdate->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':email', $email, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':phone', $phone, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':password', $password, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':hote', $hote, PDO::PARAM_INT);
            $sendRequeteUpdate->bindParam(':admin', $admin, PDO::PARAM_INT);
            $sendRequeteUpdate->bindParam(':pathPFP', $pathPFP, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':id', $id, PDO::PARAM_INT);
            if ($sendRequeteUpdate->execute()) {
                $msgok = "Les données on étaits mise à jour.";
                sleep(3);
                header("location: /Airbnb/page/home.php");
                $sendRequeteUpdate= null;
            }
        } catch (PDOException $err) {
            $msgerr = $err;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/style/StyleUpdate.css">
    <title>Document</title>
</head>
<body>
    <?php 
        $requete = "SELECT * FROM Client where ID=:id";
        $sendRequete = $db->prepare($requete);
        $sendRequete->bindParam(':id', $id, PDO::PARAM_INT);
        $sendRequete->execute();
        $UserInfo = $sendRequete->fetch(PDO::FETCH_ASSOC);
        if ($UserInfo["Hote"] == 1) {
            $CheckBoxHote = 1;
        }
        if ($UserInfo["Admins"] == 1) {
            $CheckBoxAdmin = 1;
        }
    ?>
    <div class="msg">
        <?php 
            if (isset($msgok)) {
                echo '<label class="valide">'.$msgok.'</label>'; 
            }
            else if (isset($msgerr)) {
                echo '<label class="err">'.$msgerr.'</label>'; 
            }
        ?>
    </div>
    <div class="main">
        <form method="post" enctype="multipart/form-data" >
            <h1>Mise à jour des données</h1>
            <div class="label-input">
                <label>Nom</label>
                <input type="text" name="nom" value="<?= $UserInfo["Nom"];?>">
            </div>
            <div class="label-input">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?= $UserInfo["Prenom"];?>">
            </div>
            <div class="label-input">
                <label>Email</label>
                <input type="text" name="email" value="<?= $UserInfo["Email"];?>">
            </div>
            <div class="label-input">
                <label>Téléphone</label>
                <input type="tel" name="phone" value="<?= $UserInfo["Phone"];?>">
            </div>
            <div class="label-input">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="PASSWORD" required>
            </div>
            <div class="label-input">
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?= $UserInfo["Adresse"];?>">
            </div>
            <div class="label-input">
                <label>PHOTO DE PROFILE</label>
                <input type="file" name="pfp">
            </div>
            <div class="label-input">
                <label>HÔTE</label>
                <?php 
                    if ($CheckBoxHote == 1) {
                        echo '<input type="checkbox" name="hote" checked>';
                    }
                    else {
                        echo '<input type="checkbox" name="hote">';
                    }
                    if ($_SESSION['isAdmin']) {
                        echo "<label>ADMIN</label>";
                        if ($CheckBoxAdmin == 1) {
                            echo '<input type="checkbox" name="admin" checked>';
                        }
                        else {
                            echo '<input type="checkbox" name="admin">';
                        }
                    }
                ?>
            </div>
            <div class="button">
                <button class="UpdateButton" type="submit" name="UPDATES">Mise a jour</button>
            </div> 
        </form>
    </div>
</body>
</html>