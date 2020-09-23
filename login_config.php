<?php 
 include("config.php");
 include("authentication.php");

 session_start();
 $error = '';
 if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myemail = mysqli_real_escape_string($connection, $_POST['email']);
    $mypassword = mysqli_real_escape_string($connection, $_POST['password']); 
    if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
      $error = "Invalid format and please re-enter valid email"; 
   }
   else{
    $sql = "SELECT * FROM `users` WHERE email = '$myemail'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    $authentication = new Authentication($row["username"], $row["email"], $row["phone"], $row["password"]);
    // If result matched $myusername and $mypassword, table row must be 1 row	
    if($count == 1 && password_verify($mypassword, $row['password'])) {
        $myusername = $row["username"];
       $_SESSION['login_user'] = $authentication;
       $_SESSION['login_time'] = time();

       header("location: welcome.php");
    }else {
       $error = "Your Login Name or Password is invalid";
       echo $error;
    }
  }
 } 
 ?>