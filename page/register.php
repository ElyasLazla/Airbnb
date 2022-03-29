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
        <form method="post">
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
                <input type="text" name="adresse" placeholder="ADRESSE" required>
            </div>
            <div class="hote">
                <label>HOTE</label>
                <input type="checkbox" name="hote" required>
            </div>
            <div class="externe">
                <button class="inscription" type="submit" name="LOGIN">CRÉATION</button>
                <a class="connection" href="/Airbnb/page/login.php">CONNEXION</a>
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