<?php
header('Content-Type: application/json');
include_once("../scripts/redirect.php");
check_authentication();
       
if ((!isset($_POST['id']) || !isset($_POST['name'])) || (!isset($_POST['skills']) || !isset($_POST['notes']) )) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/search");
   exit; 
}

include_once("../scripts/get_result.php");

$id = $_POST['id'];
$name = remove_chars($_POST['name']);
$skills = remove_chars($_POST['skills']);
$notes = remove_chars($_POST['notes']);
$response = "Success";

try {
   $statement = "UPDATE talents SET name = '$name', skills = '$skills', notes = '$notes' WHERE id = $id";
   $temp = query_db($statement);
   if ($temp == false) {
      $response = "There was an error updating the talent.";
   }
   
} catch (Exception $e) {
   echo json_encode(array("response"=>$e->getMessage())); 
}
   echo json_encode(array("response"=>$response));
?>
