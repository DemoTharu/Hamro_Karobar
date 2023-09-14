<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $date = $mydata['date'];
    $cname = $mydata['cname'];
    $sname = $mydata['sname'];
    $qty = $mydata['qty'];
    $rate = $mydata['rate'];
    $dis = $mydata['dis'];
    $stats = $mydata['stats'];
    
//Insert and Update
        $sql = "UPDATE `sales` SET `Date` = '$date', `C_Name` = '$cname', `S_Name` = '$sname', `S_Qty` = '$qty', `S_Rate` = '$rate', `S_Dis` = '$dis', `S_Status` = '$stats' WHERE `sales`.`SN` = {$id}";
        if($con->query($sql) == TRUE){
            echo "<i class='fa-solid fa-circle-check'></i> Data Updated";
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
        }

?>