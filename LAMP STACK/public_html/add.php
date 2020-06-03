<?php
include_once("../scripts/redirect.php");
check_authentication();  
?>

<!DOCTYPE html>
<html>
<head>
<?php include_once("../scripts/header.php");
?>

<title>Add Talent</title>
<script language="javascript">

function addTalent() {
    name = document.getElementById("name").value;
    if (name == "") {
        alert("Please specify a name.");
        return;
    } else {
    
    skills = document.getElementById("skills").value;
    notes = document.getElementById("notes").value;
    
    try {
    $.ajax({
    type: "POST",
    url: "/add_talent",
    data: {
    "name" : name,
    "skills" : skills,
    "notes" : notes
    }, success: function(data) {
       if (data.response == "Success") {
       alert("Successfully added new talent: " + name);
       reset(); 
    } else {
      alert(data.response); 
    }
    }
});

}  catch (error) {
        alert("There was an error connecting to the database. Check your Internet connection and try again." + error.message);
    }
  }
}

function reset(){
    document.getElementById("name").value = "";
    document.getElementById("skills").value = "";
    document.getElementById("notes").value = "";
    document.getElementById("name").focus();
}

</script>
</head>
<body>
<?php include_once("../scripts/navigationbar.php"); ?>
<div id="form_div">
<label for="name">Name:</label><br><br>
<input type = "text" id="name" max_length = 50 name = "text_input" style="width: 20vw; font-size: 15px; font-family: Arial; resize:none"><br><br>
<label for="skills">Skills:</label><br><br>
<textarea id="skills" rows ="4" max_length = 1000 style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<label for="notes">Notes:</label><br><br>
<textarea id="notes" rows ="4" max_length = 1000 style="width: 60vw; font-size: 15px; font-family: Arial; resize:none"></textarea><br><br>
<button type="button" onClick = "addTalent()">Add</button>
</div>
</body>
</html>