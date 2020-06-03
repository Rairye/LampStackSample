<?php
include_once("../scripts/redirect.php");
check_authentication();

if (!isset($_GET["id"])) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/search");
   exit;
}

include_once("../scripts/get_result.php");
    
$id = $_GET['id'];
$name = NULL;
$skills = NULL;
$notes = NULL;
$error_message = "";
$search_statement = "SELECT * FROM talents WHERE id = $id";

try {
     $result = query_db($search_statement);
     if (!$result) {
        $error_message = "A connection could not be made to the database. Please check your Internet connection and try again.";
        return;
     }
     
   if ($result == false) {
     $error_message = "The database returned an empty result. Please return to the Search page and try again.";
     return; 
   } else {
   
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $skills = $row['skills'];
        $notes = $row['notes'];
    }
    }
    } catch (Exception $e) {
       $error_message = "There wasn an error obtaining the result. Please return to the Search page and try again.";
       return; 
    }
?>

<!DOCTYPE html>
<html>
<head>
<?php include_once("../scripts/header.php");
?>
<title>Edit Talent</title>
<script language="javascript">
var id = null;

function getValues(){
    var errorMessage = "<?php echo $error_message; ?>";

    if (errorMessage != "") {
        alert(errorMessage);
    }
    id = parseInt("<?php echo $id;?>");
    var name  = "<?php echo $name;?>";
    var skills = "<?php echo $skills;?>";
    var notes = "<?php echo $notes;?>";
 
    if ((id == undefined || name == undefined) || (skills == undefined || notes == undefined)) {
        alert("The record in question no longer exists. Please refresh the search results and try again.");
    } else {
        document.getElementById("name").value = name;
        document.getElementById("skills").value = skills;
        document.getElementById("notes").value = notes;
    }
}

function updateTalent() {
    name = document.getElementById("name").value;
    skills = document.getElementById("skills").value;
    notes = document.getElementById("notes").value;
    
    
    if (name == "" && (skills == "" && notes  == "")) {
        alert("Unable to update an empty entry. If you would like to delete it, please click 'Delete'.");
        return;
    }
    
    try {
    $.ajax({
    type: "POST",
    url: "/update_talent",
    data: {
    "id" : id,
    "name" : name,
    "skills" : skills,
    "notes" : notes
    }, success: function(data) {
      if (data.response = "Success") {
        alert("Talent was updated successfully.");
      } else {
        alert("Invalid request. Please try again.");
      }
    }
});

}  catch (error) {
        alert("There was an error connecting to the database. Check your Internet connection and try again.");
    }
}

function deleteTalent() {
    
    try {
    $.ajax({
    type: "POST",
    url: "/delete_talent",
    data: {
    "id" : id
      }, success: function(data) {
      if (data.response = "Success") {
        alert("Talent was deleted successfully.");
      } else {
        alert(data.response);
      }
    }
});

}  catch (error) {
        alert("There was an error connecting to the database. Check your Internet connection and try again.");
    }
}
</script>
</script>
</head>
<body onload="getValues()">
<div id="form_div">
<label for="name">Name:</label><br><br>
<input type = "text" id="name" max_length = "50" name = "text_input" style="width: 20vw; font-size: 15px; font-family: Arial; resize:none"><br><br>
<label for="skills">Skills:</label><br><br>
<textarea id="skills" rows ="4" max_length = "1000" style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<label for="notes">Notes:</label><br><br>
<textarea id="notes" rows ="4" max_length = "1000" style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<div style="flex_direction : row; display : flex"><div><button type="button" onClick = "updateTalent()">Update</button></div><div style = "padding-left: 30px"> <button type="button" onClick = "deleteTalent()">Delete</button></div></div>
</div>
</body>
</html>