<?php
     include('../database/database.php');
     foreach($_POST['C_Name'] as $index => $val) {
        $date = date('Y-m-d');
        $name  = $val;
        $sname = $_POST['S_Name'][$index];
        $qty = $_POST['S_Qty'][$index];
        $rate = $_POST['S_Rate'][$index];
        $dis = $_POST['S_Dis'][$index];
        $stat = $_POST['S_Stats'][$index];
        
        
            $sql = "insert into sales (Date,C_Name, S_Name,S_Qty,S_Rate,S_Dis,S_Status) values ('$date', '$name', '$sname', '$qty', '$rate', '$dis', '$stat')";
            $result = mysqli_query($con, $sql);
            echo "<i class='fa-solid fa-circle-check'></i> Successfully Submitted";
        
}


    ?>