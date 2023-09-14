<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $name = $mydata['name'];
    $pan = $mydata['pan'];
    $add = $mydata['add'];
    $email = $mydata['email'];
    $mobi = $mydata['mobi'];
    
//Insert and Update
     if (!empty($name) && !empty($pan) && !empty($add) && !empty($email) && !empty($mobi)) {
        $sql = "INSERT INTO `vender` (`SN`, `V_Name`, `V_Pan`, `V_Add`, `V_Email`, `V_Mobile`) VALUES ('$id', '$name', '$pan', '$add', '$email', '$mobi') ON DUPLICATE KEY UPDATE V_Name = '$name',V_Pan = '$pan',V_Add = '$add', V_Email = '$email', V_Mobile = '$mobi'";
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