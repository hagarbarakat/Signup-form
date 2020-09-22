<?php
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $connection = mysqli_connect("localhost", "root","Pinkfloyd_1",'new_admin') or die("Unable to connect");
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $mypassword = mysqli_real_escape_string($connection, $_POST['password']); 
      
      $sql = "INSERT INTO `users`(`username`, `password`, `email`, `phone`) VALUES ('$username','$password', '$email', '$phone')";
      $result = mysqli_query($connection, $sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         
         header("location: welcome.php");
      }else {
         $error = "Failed";
      }
   }
?>

<!DOCTYPE html>
<html>

    <head>
    <meta charset="utf-8">
    <title>Signup</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body style="margin-left: 2%;">
        <h1>SignUp</h1>
        <div style="width: 50%;">
        <form action="" method="POST">
            <div class="form-group">
                <label for="exampleName1">Name</label>
                <input type="text" name ="username" class="form-control" id="exampleInputName1">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name ="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="exampleInputPhone1">Phone</label>
                <input type="text" name="phone" class="form-control" id="exampleInputPhone1">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name ="password" class="form-control" id="exampleInputPassword1">
            </div>
            <a href="login1.php" style="display: block; margin-bottom: 1%;">Already have an account?</a>
            <button type="submit" name ="submit" class="btn btn-primary">Submit</button>
            <span><?php echo $message; ?></span>
          </form>
        </div>
    </body>
</html>
