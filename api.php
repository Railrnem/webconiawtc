<?php
    $servername="localhost";
    $username="webconiawtc";
    $password="nwWhUPS8JrV5uzX";

    $con = new mysqli($servername, $username, $password);

    if($con->connect_error)
    {
        die("Connection failed: " . $con-connect_error);
    }
    echo "Connected successfully";
?>