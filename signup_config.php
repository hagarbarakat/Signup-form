<?php
 include("config.php");
 session_start();
 $error = "";
 $flag = 0;
 if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    $myemail = mysqli_real_escape_string($connection, $_POST['email']);
    $mypassword = mysqli_real_escape_string($connection, $_POST['password']); 
    $psswd = PASSWORD_HASH($mypassword, PASSWORD_DEFAULT);
    $myphone = mysqli_real_escape_string($connection, $_POST['phone']); 
    $username = mysqli_real_escape_string($connection, $_POST['username']); 
   if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
      $error = "Invalid format and please re-enter valid email\n"; 
      $flag = 1;
   }
   if(!preg_match('/^\d{11}$/', $myphone)) {
      $error .= "Phonenumber must contain numbers only<br>";
      $flag = 1;
     }
   if(strlen($mypassword) < 8){
      $error .= "Password is less than 8 characters<br>";
      $flag = 1;

   }
   if($flag == 0){
    $sql = "INSERT INTO users (username, password, email, phone) VALUES ('$username','$psswd', '$myemail', '$myphone')";
    $result = mysqli_query($connection, $sql);
    if ($result === TRUE) {
       $_SESSION['login_user'] = $username;
       $_SESSION['login_time'] = time();
       header("location: welcome.php");
    }
    else {
       $error = "Username is already used";
       echo $error;
    }
  }
 }
 ?>