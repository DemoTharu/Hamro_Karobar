<?php
session_start();
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $pass = $mydata['pass'];
    $npass = $mydata['npass'];
    $rpass = $mydata['rpass'];
    $user = $_SESSION['new'];
    if ($pass == $_SESSION['pass']) {
           if ($npass == $rpass) {
                 //Insert and Update
                $sql = "UPDATE `user` SET `Password` = '$npass' WHERE `user`.`Username` = '$user'";
                if($con->query($sql) == TRUE){
                    $_SESSION['pass'] = $npass;
                    echo "<i class='fa-solid fa-circle-check'></i> Password Updated";
                }
                else{
                    echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
                }
           }
           else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Password Not Matched";
           }
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Old Password Not Matched";
        }
    
?>