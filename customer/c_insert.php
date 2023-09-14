<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $name = $mydata['name'];
    $add = $mydata['add'];
    $email = $mydata['email'];
    $mobi = $mydata['mobi'];
    
//Insert and Update
     if (!empty($name) && !empty($add) && !empty($email) && !empty($mobi)) {
        $sql = "INSERT INTO `customer` (`SN`, `C_Name`, `C_Add`, `C_Email`, `C_Mobile`) VALUES ('$id', '$name', '$add', '$email', '$mobi') ON DUPLICATE KEY UPDATE C_Name = '$name',C_Add = '$add', C_Email = '$email', C_Mobile = '$mobi';";
        if($con->query($sql) == TRUE){
            echo "<i class='fa-solid fa-circle-check'></i> Successfully Submitted";
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
        }
    }
    else{
        echo "<i class='fa-solid fa-circle-xmark'></i> Fill the Empty Input";
    }
?>