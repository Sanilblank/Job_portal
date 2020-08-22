<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "job_portal";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if(!$conn){
        die("Failed");
    }
