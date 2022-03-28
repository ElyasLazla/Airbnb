<?php 
    require_once "./module/connectDB.php";
    session_start();
    if (!isset($_SESSION["session_open"])) {
        header("location: /Airbnb/page/login.php");
        exit();
    }

    $nbUser=0;
    try {
        $error = false;
        $email = $_SESSION['session_email'];

        $CheckDBadmins = "SELECT Admins, Prenom FROM Client where Email = :email";
        $sendRequeteAdmin = $db->prepare($CheckDBadmins);
        $sendRequeteAdmin->bindParam(':email', $email, PDO::PARAM_STR);
        $sendRequeteAdmin->execute();
        $row= $sendRequeteAdmin->fetch(PDO::FETCH_ASSOC);

        $GetDataClient = 'SELECT * FROM Client';
        $sendRequeteClient = $db->prepare($GetDataClient);

    } catch (PDOException $e) {
        $error = $e;
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/style/StyleHome.css">
    <title>Info base de donnée.</title>
</head>
<body>
    <header>
        <div class="user">
            <h3><?php echo $row["Prenom"]?></h3>
            <img src="./asset/img/admin.png">
            <?php
                /* echo '<img src="GetImage.php?i='. urldecode($pathImg) .'">'; */
            ?>
        </div>
        <div class="button">
            <a class="Ajout" href="./page/ajout.php" target="true">Ajouter</a>
            <a href="/Airbnb/page/logout.php">Se déconnecter</a>
        </div>
    </header>
    <hr>
    <div class="msg">
        <?php
            if ($error){
                echo "<p class='err'>Mmmh, une erreur vient de ce produire!: " . $error->getMessage() . "</p>";
                die();
            }
            if ($row['Admins'] == 1) {
                $row = null;
                $sendRequeteClient->execute();?>
                <?php  while ($row= $sendRequeteClient->fetch(PDO::FETCH_ASSOC)): $nbUser ++;?>
                    <table class="customersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Prenom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Adresse</th> 
                                <th>Hote</th>
                                <th>Date de création</th>
                                <th>Date de modification</th>   
                                <th>Admin</th>     
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="Label">ID</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['id']); ?></td>

                                <td class="Label">Prénom</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Prenom']); ?></td>

                                <td class="Label">Nom</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Nom']); ?></td>

                                <td class="Label">Email</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Email']); ?></td>

                                <td class="Label">Téléphonne</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Phone']); ?></td>

                                <td class="Label">Adresse</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Adresse']); ?></td>

                                <td class="Label">Hôte</td>
                                <?php
                                    if (htmlspecialchars($row['Hote']) == 1) {
                                        echo "<td class='infoUser'><img src='./asset/img/ok.png'></td>";
                                    }
                                    else {
                                        echo "<td class='infoUser'><img src='./asset/img/no.png'></td>";
                                    }
                                ?>
                                
                                <td class="Label">Date de création</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['Date_Creation']); ?></td>

                                <td class="Label">Date de modification</td>
                                <td class="infoUser"><?php echo htmlspecialchars($row['DateModification']); ?></td>
                                <td class="Label">Admin</td>
                                <?php
                                    if (htmlspecialchars($row['Admins']) == 1) {
                                        echo "<td class='infoUser'><img src='./asset/img/ok.png'></td>";
                                    }
                                    else {
                                        echo "<td class='infoUser'><img src='./asset/img/no.png'></td>";
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
        <?php 
                endwhile;
                if ($nbUser == 0) {
                    echo "<p class='valide'>Mmmh, la base <strong>Client</strong> est vide</p>";
                    die();
                }
        ?>
        <?php 
                if ($nbUser == 0) {
                    echo "<p class='valide'>Mmmh, la base <strong>Client</strong> est vide</p>";
                    die();
                }
            }
            else {
                try {
                    $error = false;
                    $getDBclient = $db->query('SELECT * FROM Client');
                    $row= $getDBclient->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $error = $e;
                }
        ?>
                <table class="customersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prenom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th> 
                            <th>Hote</th>
                            <th>Date de création</th>
                            <th>Date de modification</th>     
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="Label">ID</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['id']); ?></td>

                            <td class="Label">Prénom</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Prenom']); ?></td>

                            <td class="Label">Nom</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Nom']); ?></td>

                            <td class="Label">Email</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Email']); ?></td>

                            <td class="Label">Téléphonne</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Phone']); ?></td>

                            <td class="Label">Adresse</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Adresse']); ?></td>

                            <td class="Label">Hôte</td>
                            <?php
                                if (htmlspecialchars($row['Hote']) == 1) {
                                    echo "<td class='infoUser'><img src='./asset/img/ok.png'></td>";
                                }
                                else {
                                    echo "<td class='infoUser'><img src='./asset/img/no.png'></td>";
                                }
                            ?>
                            
                            <td class="Label">Date de création</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['Date_Creation']); ?></td>

                            <td class="Label">Date de modification</td>
                            <td class="infoUser"><?php echo htmlspecialchars($row['DateModification']); ?></td>
                        </tr>
                    </tbody>
                </table>
        <?php
            }
        ?>
    </div>
</body>
</html>
