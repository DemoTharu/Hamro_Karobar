<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "hamro_karobar";

    $con = new mysqli($host,$user,$pass,$db);

    if($con->connect_error){
        die("Connection Failed");
    }
?>