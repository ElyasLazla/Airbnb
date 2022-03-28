<?php
    session_start();
    if (isset($_SESSION['session_open'])) {
        header("location: /Airbnb/index.php");
        exit();
    }

    if (isset($_REQUEST['LOGIN'])) {

        $email = trim($_REQUEST['email']);
        $password = trim($_REQUEST["password"]);

        if (empty($email)) {
            $errorMsg[] = "Veuillez entrez votre mail.";
        }
        elseif (empty($password)) {
            $errorMsg[]="Entrez votre mot de passe";
        }
        else {
            try {
                $db = new PDO('mysql:host=185.31.40.32:3306;dbname=elyas-lazla_airbnb', "250295", "StarWars2003?");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                $requete = "SELECT * FROM Client where Email = :email and Passwords = :passwords";
                $sendRequete = $db->prepare($requete);
                $sendRequete->bindParam(':email', $email, PDO::PARAM_STR);
                $sendRequete->bindParam(':passwords', $password, PDO::PARAM_STR);
                $sendRequete->execute();
    
                $count = $sendRequete->rowCount();
                $row = $sendRequete->fetch(PDO::FETCH_ASSOC);
    
                if ($count == 1 && !empty($row)) {
                    $_SESSION['session_user_id']  = $row['id'];
                    $_SESSION['session_email'] = $row['Email'];
                    $_SESSION['session_nom'] = $row['Nom'];
                    $_SESSION['session_open'] = true;
                    header("location: /Airbnb/page/home.php");
                    exit();
                }
                else {
                    $msg = "Email ou mot de passe incorrecte";
                }
            } catch (PDOException $err) {
                $msg = "Une erreur c'est produite: ". $err->getMessage();
            }
        } 
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/style/StyleLogin.css">
    <title>Connexion</title>
</head>
<body>
  <div class="main">
        <form method="post">
            <h1>Connexion</h1>
            <div class="username">
                <input type="email" name="email" placeholder="Votre mail">
            </div>
            <div class="password">
                <input type="password" name="password" placeholder="Mot de passe">
            </div>
            <div class="externe">
                <button class="connection" type="submit" name="LOGIN">CONNECTION</button>
                <a class="inscription" href="/Airbnb/page/register.php">INSCRIPTION</a>
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