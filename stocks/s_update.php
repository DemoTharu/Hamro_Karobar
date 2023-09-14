<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $qty = $mydata['qty'];
    
//Insert and Update
        $sql = "UPDATE `purchase` SET `P_Qty` = '$qty' WHERE `purchase`.`SN` = {$id} AND P_Return = 0";
        if($con->query($sql) == TRUE){
            echo "<i class='fa-solid fa-circle-check'></i> Data Updated";
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
        }

?>