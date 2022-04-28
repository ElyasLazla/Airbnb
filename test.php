<?php
    $msg;
    $uploadOk = 1;
    $target_dir = "page/asset/img/user/";

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $target_file = $target_dir.basename($_FILES["pfp"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["pfp"]["tmp_name"]);
        
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $msg = "Ce fichier n'est pas une image.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $msg = "Désoler mais ce fichier n'ets pas une image (JPG, PNG, JPEG, gif).";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = "Désoler une erreur c'ets produite.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_file)) {
                $msg = "Le fichier à était télécharger";
            } else {
                $msg = "Ooh non, une erreur vient de se produire !";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div class="filePDP">
            <input type="file" name="pfp">
        </div>
        <button class="inscription" type="submit" name="submit">CRÉATION</button>
    </form>
</body>
</html>