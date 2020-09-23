<?php
   include("authentication.php");
   include("config.php");
   session_start();
   if( !isset( $_SESSION['login_user'] ) || time() - $_SESSION['login_time'] > 60)
   {
      header("location:login.php");
      die();
   }
   else
   {
      // uncomment the next line to refresh the session, so it will expire after ten minutes of inactivity, and not 10 minutes after login
      //$_SESSION['login_time'] = time();
      $connection = mysqli_connect("localhost", "root","",'new_admin') or die("Unable to connect");

      $user_check = $_SESSION['login_user']->getName();
      $ses_sql = mysqli_query($connection,"SELECT * FROM users where username = '$user_check'");
      
      $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
      
      $login_session =new Authentication($row["username"], $row["email"], $row["phone"], $row["password"]);
   }
?>