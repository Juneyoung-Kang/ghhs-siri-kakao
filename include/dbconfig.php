<?php
    $db_server          = "localhost";
    $db_id              = "juneyoung";
    $db_password        = "";
    $db_name            = "juneyoung";

    $mysqli = new mysqli($db_server, $db_id, $db_password, $db_name);
    $mysqli->set_charset("utf8");

    $conn = mysqli_connect($db_server, $db_id, $db_password, $db_name);
    mysqli_query($conn, "SET CHARSET UTF8");

    if($conn -> connect_error){
        die ("DB Connect failed".$conn->connect_error);
    }

    function mq($sql){
        global $mysqli;
        return $mysqli->query($sql);
    }
?>