<?php
    include('../database/database.php');
    if (isset($_POST['input'])) {
        $input = $_POST['input'];

    $sql = "SELECT * FROM sales WHERE C_Name LIKE '{$input}%' OR S_Name LIKE '{$input}%' OR S_Status LIKE '{$input}%'";
    $result = $con->query($sql);
    if($result->num_rows > 0){
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
    }else{
        echo "<i class='fa-solid fa-circle-xmark'></i> Fill the Empty Input";
    }

    //Return Data in JSON format to response to ajax
    echo json_encode($data);
    }
?>