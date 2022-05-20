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

        $CheckDBadmins = "SELECT Admins, Prenom, PathPFP FROM Client where Email = :email";
        $sendRequeteAdmin = $db->prepare($CheckDBadmins);
        $sendRequeteAdmin->bindParam(':email', $email, PDO::PARAM_STR);
        $sendRequeteAdmin->execute();
        $FetchAdmin= $sendRequeteAdmin->fetch(PDO::FETCH_ASSOC);

        $GetDataClient = 'SELECT * FROM Client';
        $sendRequeteClient = $db->prepare($GetDataClient);
        $sendRequeteClient->execute();

        $NameImgUser = $FetchAdmin["PathPFP"];
        if ($NameImgUser == "" || $NameImgUser == " " || $NameImgUser == "NOT NULL") {
            $NameImgUser = "./asset/img/user/default.jpg";
        }
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
    <link rel="icon" href="<?= $NameImgUser ?>"/>
    <title>Info base de donnée.</title>
</head>
<body>
    <header>
        <div class="user">
            <h3><?php echo $FetchAdmin["Prenom"]?></h3>
            <img src="<?= $NameImgUser ?>">
        </div>
        <div class="button">
            <?php
            if ($FetchAdmin['Admins'] == 1) {
                echo "<a class='Ajout' href='/Airbnb/page/register.php' target='true'>Ajouter</a>";
            }
            ?>
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
            if ($FetchAdmin['Admins'] == 1) {
                $FetchAdmin = null;
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
                                <th>Admin</th>   
                                <th>Label</th>  
                            </tr>
                        </thead>
                        <?php  while ($FetchClient= $sendRequeteClient->fetch(PDO::FETCH_ASSOC)): $nbUser ++;?>
                        <tbody>
                            <tr>
                                <td class="Label">ID</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['id']); ?></td>

                                <td class="Label">Prénom</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Prenom']); ?></td>

                                <td class="Label">Nom</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Nom']); ?></td>

                                <td class="Label">Email</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Email']); ?></td>

                                <td class="Label">Téléphonne</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Phone']); ?></td>

                                <td class="Label">Adresse</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Adresse']); ?></td>

                                <td class="Label">Hôte</td>
                                <?php
                                    if (htmlspecialchars($FetchClient['Hote']) == 1) {
                                        echo "<td class='infoUser'><img src='./asset/img/ok.png'></td>";
                                    }
                                    else {
                                        echo "<td class='infoUser'><img src='./asset/img/no.png'></td>";
                                    }
                                ?>
                                
                                <td class="Label">Date de création</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['Date_Creation']); ?></td>

                                <td class="Label">Date de modification</td>
                                <td class="infoUser"><?php echo htmlspecialchars($FetchClient['DateModification']); ?></td>
                                <td class="Label">Admin</td>
                                <?php
                                    if (htmlspecialchars($FetchClient['Admins']) == 1) {
                                        echo "<td class='infoUser'><img src='./asset/img/ok.png'></td>";
                                    }
                                    else {
                                        echo "<td class='infoUser'><img src='./asset/img/no.png'></td>";
                                    }
                                ?>
                                <td class="Label">OPTION</td>
                                <td><a href="/Airbnb/page/update.php?id=<?php echo $FetchClient["id"]; ?>" target="true">Update</a></td>
                            </tr>
                        </tbody>
                        <?php endwhile;?>
                    </table>
        <?php 
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
                    $getDBclient = $db->prepare('SELECT * FROM Client where Email= :email');
                    $getDBclient->bindParam(':email', $email, PDO::PARAM_STR);
                    $getDBclient->execute();
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
                            <th>OPTION</th>   
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
                            
                            <td class="Label">OPTION</td>
                            <td><a href="/Airbnb/page/update.php?id=<?php echo $row["id"]; ?>">Update</a></td>
                        </tr>
                    </tbody>
                </table>
        <?php
            }
        ?>
    </div>
</body>
</html>