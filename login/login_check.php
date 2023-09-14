<?php
session_start();
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $uname = $mydata['uname'];
    $pass = $mydata['pass'];
//Insert and Update
        $sql = "SELECT * FROM `user` WHERE Username = '$uname' AND Password = '$pass'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($count == 1){ 
            $_SESSION['new'] = $uname;
            $_SESSION['pass'] = $pass;
            echo "<i class='fa-solid fa-circle-exclamation'></i> Login Successful";  
                }  
        else{  
            echo "<i class='fa-solid fa-circle-exclamation'></i> Username or Password Not Matched";  
        } 
?>