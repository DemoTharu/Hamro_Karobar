<?php
    include('../database/database.php');

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];
    $vender = $mydata['vender'];
    $name = $mydata['name'];
    $qty = $mydata['qty'];
    $rate = $mydata['rate'];
    $dis = $mydata['dis'];
    $dates = $mydata['dates'];
    $date = date('Y-m-d');
    
//Insert and Update
if(!empty($id) && !empty($vender) && !empty($name) && !empty($qty) && !empty(rate) && !empty($dis)){
    $sql = "INSERT INTO `purchase` (`SN`, `Date`, `V_Name`, `P_Name`, `P_Qty`, `P_Rate`, `P_Dis`) VALUES ('$id', '$date', '$vender', '$name', '$qty', '$rate', '$dis') ON DUPLICATE KEY UPDATE Date = '$dates',V_Name = '$vender',P_Name = '$name', P_Qty = '$qty', P_Rate = '$rate',  P_Dis = '$dis';";
        if($con->query($sql) == TRUE){
            echo "<i class='fa-solid fa-circle-check'></i> Successfully Inserted";
        }
        else{
            echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, check again";
        }
}
else{
    echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, Fill All";
}

?>