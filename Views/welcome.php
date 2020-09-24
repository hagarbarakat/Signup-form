<?php
   include('../Auth/auth.php');
   session_start();
   $auth = new auth();
   $loginSession = $auth->getLoginSession();
   if(isset($_GET['logout'])){
      $auth->logout();
   }
?>

<html">
   
   <head>
      <title>Welcome </title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   </head>
   
   <body>
      <h1>Welcome <?php echo $loginSession; ?></h1> 
      <h2><a href = "?logout">Log Out</a></h2>
   </body>
   
</html>