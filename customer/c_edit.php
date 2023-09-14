<?php
    include("../database/database.php");

    $data = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($data, true);
    $id = $mydata['id'];

    //retrive customer info
    $sql = "SELECT * FROM customer WHERE SN = {$id}";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    //Return in json format
    echo json_encode($row);
?>