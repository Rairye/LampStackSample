<?php
   function check_authentication() {
   session_start();
   if (!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/login");
   exit;
  }
}
?>