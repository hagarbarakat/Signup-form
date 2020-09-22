<?php
   session_start();
   $connection = mysqli_connect("localhost", "root","",'new_admin') or die("Unable to connect");

   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($connection,"SELECT username FROM users where username = '$user_check'");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];

   if(!isset($_SESSION['login_user'])){
        #header("location:login1.php");
      die();
   }
?>