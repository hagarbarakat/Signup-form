<?php
   session_start();
   $error = '';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $connection = mysqli_connect("localhost", "root","",'new_admin') or die("Unable to connect");
      $myemail = mysqli_real_escape_string($connection, $_POST['email']);
      $mypassword = mysqli_real_escape_string($connection, $_POST['password']); 
      if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid format and please re-enter valid email"; 
     }
     else{
      $sql = "SELECT username FROM `users` WHERE email = '$myemail' and password = '$mypassword'";
      $result = mysqli_query($connection, $sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      $myusername = $row["username"];
      //echo $myusername;
      // If result matched $myusername and $mypassword, table row must be 1 row		
      if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         
         header("location: welcome.php");
      }else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
      }
    }
   }
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body>
        <div style="margin-left: 2%;" >
        <h1>Login</h1>
        <div style="width: 50%;">
        <form action="" method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="email" class="form-control" id="exampleInputEmaillogin" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPasswordlogin">
            </div>
            <a href="signup1.php" style="display: block; margin-bottom: 1%;">Create an account?</a>
            <button type="submit"name= "submit" class="btn btn-primary">Submit</button>
            <span><?php echo $error; ?></span>
          </form>
        </div>
    </div>
    </body>
</html>