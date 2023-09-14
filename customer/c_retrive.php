<?php
    include('../database/database.php');
    //Retrive Customer Data
    $sql = "SELECT * FROM customer";
    $result = $con->query($sql);
    if($result->num_rows > 0){
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
    }

    //Return Data in JSON format to response to ajax
    echo json_encode($data);
?>