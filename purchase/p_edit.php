<?php
    include("../database/database.php");

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];

    //retrive purchase info
    if(!empty($id)){
        $sql = "SELECT * FROM purchase WHERE SN = {$id}";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();

        //Return in json format
        echo json_encode($row);
    }
    else{
        echo "<i class='fa-solid fa-circle-exclamation'></i> Invalid input, Fill All";
    }
?>