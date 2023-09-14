<?php
    include ('../database/database.php');
    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];

    //Delete command
    if(!empty($id)){
        $sql = "DELETE FROM customer WHERE SN = {$id}";
        if($con->query($sql) == TRUE){
            echo 1;
        }
        else{
            echo 0;
        }
    }
?>