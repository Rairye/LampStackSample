<?php
        session_start();
        $host = $_SERVER['HTTP_HOST'];
        if  (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        header("Location: http://$host/");
        exit;
        }   
        $error_message = "";
        include_once("../scripts/authenticate_user.php");
        
       if (isset($_POST['submit'])) {
            $username = remove_chars($_POST['username']);
            $password = remove_chars($_POST['password']);
            try {
                $statement = "SELECT * FROM user_login WHERE username = 'username'";
                $temp = login_user($statement);
             if (mysqli_num_rows($temp) == 0) {
                $error_message = "Incorrect username or password. Please try again."; 
           } else {
           
           $row = mysqli_fetch_assoc($temp);
           if (password_verify($password, $row['password'])) {
           $_SESSION['logged_in'] = True;
           header("Location: http://$host/");
           } else {
             $error_message = "Incorrect username or password. Please try again.";
           }
          } } catch (Exception $e) {
            $error_message = "There was a server-side error. Please check your Internet connection and try again";
        }
       }
?>
<html>
<head>
<?php include_once("../scripts/header.php");
?>
<title>Login</title>
</head>
<body>
<div id="form_div">
 <form method="post" id ="loginform">
    <div>
    <label for="user"><b>User</b></label>
    </div>
    <div>
    <input type="text" name="username" required>
    </div>
    <div style="padding-top: 10px">
    <label for="password"><b>Password</b></label>
    </div>
    <div>
    <input type="password" name="password" required>
    </div>
    <div style="padding-top: 10px">
    <button type="submit" name = "submit">Login</button>
    </div>
    <div id = "loginresult" style = "color : red; margin-top: 25px">
    <?php echo $error_message?>
    </div>
</form>
</div>
</body>
</html>