<?php 
    function initialize() { 
    $connection = mysqli_connect("localhost", "user", "password", "talent_db");
 
    if (!$connection) {
        echo "There was an error connecting to the database."; 
    } else {
    $result = mysqli_query($connection, "SHOW tables;");
        echo $result;
    }
  }
?>