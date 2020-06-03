<?php
include_once("../scripts/redirect.php");
check_authentication();
       
if ((!isset($_POST['name']) || !isset($_POST['skills'])) || !isset($_POST['notes'])) {
   $host = $_SERVER['HTTP_HOST'];
   header("Location: http://$host/search");
   exit;
}

include_once("../scripts/get_result.php");
    
$name = remove_chars($_POST['name']);
$skills = remove_chars($_POST['skills']);
$notes = remove_chars($_POST['notes']);
$results_table = "";

$search_statement = ($name == "" && ($skills == "" && $notes == "")) ?  "SELECT * FROM talents" : "SELECT * FROM talents WHERE";
    
    if ($name != "") {
        $search_statement .= " name LIKE " . ($skills == "" && $notes == "" ? "'%$name%'" : "'%$name%' AND");
    }
    if ($skills != "") {
        $search_statement .= " skills LIKE " . ($notes == "" ? "'%$skills%'" : "'%$skills%' AND");
    }
    if ($notes != "") {
        $search_statement .= " notes LIKE '%$notes%'";
    }
    $search_statement .= " ORDER BY name";

try {
     $results = query_db($search_statement);
   if ($results == false) {
      $results_table = "There was an error obtaining the search results.";
   } else {
   
   $results_table = "";
    $i = 0;

    while ($row = mysqli_fetch_assoc($results)) {
    
        $row_number = $row['id'];
        
        $result_div = "<hr name ='table_hr'>";
        
        $result_div .= "<div name='result_div'><text name = 'result_text_heading'>Result " . ($i + 1) . "</text><br><br>";
        
        $result_div .= "<text name ='result_text_heading'>Name: </text><text name='result_text_body'>" . $row['name'] . "</text><br><br>";

        $result_div .= "<text name ='result_text_heading'>Skills: </text><text name = 'result_text_body'>" . ($row['skills'] != "" ? $row['skills'] : "") . "</text><br><br>";
        
        $result_div .= "<text name ='result_text_heading'>Notes: </text><text name = 'result_text_body'>" . ($row['notes'] != "" ? $row['notes'] : "") . "</text><br><br>";                 

        $result_div .= "<a href = '/update?id=$row_number' target='_blank'><text name = 'result_text_body'>Update information</text></a><br><br></div>";

        $results_table .= $result_div;

        $i++; }

    if ($i == 0) {
        $results_table = "<text name ='result_text_title'>0 matches found.</text>";

    } elseif ($i == 1) {
        $results_table = "<text name = 'result_text_title'>1 match found.</text><br><br>" . $results_table;

    } else {
        $results_table = "<text name = 'result_text_title'>$i matches found.</text><br><br>" . $results_table;
        }
     }  
    } catch (Exception $e) {
   $results_table = $e->getMessage(); 
   }
?>
<!DOCTYPE html>
<html>
<head>
<?php include_once("../scripts/header.php");
?>
<title>Results</title>
<script language="javascript">
</script>
</head>
<body>
<?php include_once("../scripts/navigationbar.php") ?>
<div id = "results_table_div">
<?php
    echo $results_table;
?>
</div>
</body>
</html>