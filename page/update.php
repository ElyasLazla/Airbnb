<?php 
    if (isset($_REQUEST['UPDATE'])) {
        
        require_once "./module/connectDB.php";
        session_start();
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
        $hote = $_POST["hote"];

        try {
            $sqlUpdate = "UPDATE Client SET Nom=':nom', Prenom=':prenom', Email=':email', Phone=':phone', Passwords=':password', Adresse=':adresse', Hote=':hote', DtaeModification=CURRENT_TIME() WHERE `Client`.`:id`";
            $sendRequeteUpdate = $db->prepare($sqlUpdate);
            $sendRequeteUpdate->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':email', $email, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':phone', $phone, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':password', $password, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $sendRequeteUpdate->bindParam(':hote', $hote, PDO::PARAM_INT);
            $sendRequeteUpdate->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $sendRequeteUpdate->execute();
            $row= $sendRequeteUpdate->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $msg = $err;
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
    <div class="main">
        <form action="Airbnb/page/update.php" method="post">
            <h1>Mise à jour des données</h1>
            <div>
                <input type="text" name="nom" placeholder="NOM">
            </div>
            <div>
                <input type="text" name="prenom" placeholder="PRENOM">
            </div>
            <div>
                <input type="text" name="email" placeholder="EMAIL">
            </div>
            <div>
                <input type="text" name="phone" placeholder="TÉLÉPHONE">
            </div>
            <div>
                <input type="text" name="password" placeholder="MOT DE PASSE">
            </div>
            <div>
                <input type="text" name="adresse" placeholder="ADRESSE">
            </div>
            <div>
                <input type="text" name="hote" placeholder="HÔTE">
            </div>
            <div class="button">
                <button class="UpdateButton" type="submit" name="UPDATE">Mise a jour</button>
            </div>
            <?php 
                if (isset($msg)) {
                    echo '<label class="msg">'.$msg.'</label>'; 
                }
            ?>  
        </form>
    </div>
</body>
</html>