<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $ename = $mydata['ename'];
    $amt = $mydata['amt'];
    $date = date('Y-m-d');
    
//Insert and Update
        $sql = "INSERT INTO `expense` (`SN`, `Date`, `E_Name`, `E_Amt`) VALUES (NULL, '$date', '$ename', '$amt');";
        if($con->query($sql) == TRUE){
            echo "<i class='fa-solid fa-circle-check'></i> Successfully Submitted";
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
        }

?>