<?php
    include ('../database/database.php');
    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $returns = $mydata['returns'];
    $id = $mydata['id'];
    $date = date('Y-m-d');

    //Return command
    if(!empty($id)){
        $sql = "UPDATE `purchase` SET `P_Return` = '1', `Reason` = '$returns', `Return_Date` = '$date' WHERE `purchase`.`SN` = {$id}";
        if($con->query($sql) == TRUE){
            echo 1;
        }
        else{
            echo 0;
        }
    }
?>