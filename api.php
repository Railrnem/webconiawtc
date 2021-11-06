<?php
    $servername="localhost";
    $username="webconiawtc";
    $password="nwWhUPS8JrV5uzX";
    $dbname ="webconiawtc";

    $con = new mysqli($servername, $username, $password, $dbname);

    if($con->connect_error)
    {
        die("Connection failed: " . $con-connect_error);
    }
    
    $sql = "INSERT INTO `teilnehmer` (`t_id`, `vorname`, `nachname`, `email`, `firma`) VALUES (NULL, '"
        . $_POST["vorname"] .  "', '" 
        . $_POST["nachname"] . "', '" 
        . $_POST["email"] .    "', '" 
        . $_POST["firma"] .    "');";
    
    if($con->query($sql) === TRUE)
    {
        echo "SUCCESS";;
    }
    else
    {
        echo $sql;
        echo "Failure";
    }

    $con->close();
?>
    