<?php
header('Content-Type: application/json');
include_once("../scripts/redirect.php");
check_authentication();
       
if (!isset($_POST['id'])) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/search");
   exit; 
}

include_once("../scripts/get_result.php");
$id = $_POST['id'];
$response = "Success";

try {
   $statement = "DELETE FROM talents WHERE id = $id";
   $temp = query_db($statement);
   if ($temp == false) {
      $response = "There was an error deleting the talent.";
   }
   
} catch (Exception $e) {
   echo json_encode(array("response"=>$e->getMessage())); 
}
   echo json_encode(array("response"=>$response));
?>
