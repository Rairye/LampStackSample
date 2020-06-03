<?php 
include_once("../scripts/redirect.php");
check_authentication();       
?>

<!DOCTYPE html>
<html>
<head>
<?php include_once("../scripts/header.php");
?>
<title>Search Talent</title>
</head>
<body>
<?php include_once("../scripts/navigationbar.php") ?>
<div id="form_div">
<form id="search" action = "./results" method = "post">
<label for="name">Name:</label><br><br>
<input form = "search" type = "text" id="name" max_length = "50" name = "name" style="width: 20vw; font-size: 15px; font-family: Arial; resize:none"><br><br>
<label for="skills">Skills:</label><br><br>
<textarea form = "search" id="skills" name = "skills" rows ="4" max_length = "1000" style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<label for="notes">Notes:</label><br><br>
<textarea form = "search" id="notes" name = "notes" rows ="4" max_length = "1000" style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<input type="submit" name = "submit" value="Search">
</form>
</body>
</html>