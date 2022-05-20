<?php 
    function Upload($file, $InfoUser)
    {
        $uploaddir = 'asset/img/user/';
        $temp = explode(".", $file["name"]);
        $newName = $InfoUser['nom'] . "_" . $InfoUser['prenom'].".".end($temp);
        $uploadfile = $uploaddir.basename($newName);
    
    
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            return $newName;
        } else {
            return "error";
        }
    }

?>