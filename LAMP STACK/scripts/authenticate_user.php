<?php
    function remove_chars($string) {
        $characters = array ('\"', '\'', ';');
        $result = str_replace($characters, "", $string);
        return $result;
    }
   
    function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    function login_user($query) {
    $connection = mysqli_connect("localhost", "user", "password", "talent_db") or die();
    $result = NULL;
    mysqli_autocommit($connection, FALSE);
    
    if (!$connection){
        return "Could not connect to database.";        
    } else {
    try {
    $result = mysqli_query($connection, $query);
    mysqli_commit($connection);
    mysqli_close($connection); 
    } catch (Exception $e) {
    return $e->getMesssage();
    }
    return $result;
    }
    }
?>