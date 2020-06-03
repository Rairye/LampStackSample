<?php
header('Content-Type: application/json');
include_once("../scripts/redirect.php");
check_authentication();
       
if ((!isset($_POST['name']) || !isset($_POST['skills'])) || !isset($_POST['notes'])) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/add");
   exit; 
}

include_once("../scripts/get_result.php");
$name = remove_chars($_POST['name']);
$skills = remove_chars($_POST['skills']);
$notes = remove_chars($_POST['notes']);
$response = "Success";

try {
   $statement = "INSERT INTO talents (name, skills, notes) VALUES ('$name', '$skills','$notes')";
   $temp = query_db($statement);
   if ($temp == false) {
      $response = "There was an error adding the talent.";
   }
   
} catch (Exception $e) {
   echo json_encode(array("response"=>$e->getMessage())); 
}
   echo json_encode(array("response"=>$response));
?>
