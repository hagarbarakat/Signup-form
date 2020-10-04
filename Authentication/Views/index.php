<?php
  session_start();
   include("../Auth/auth.php");
   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
   $arr = array('email'=>$_POST['email'], 'password'=>$_POST['password'], 'phone'=>$_POST['phone'], 'name'=>$_POST['username']);
   $auth  = new auth();
   $error =  $auth->signup($arr);
   }
 ?>

<!DOCTYPE html>
<html>

    <head>
    <meta charset="utf-8">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
            <a href="login.php" style="display: block; margin-bottom: 1%;">Already have an account?</a>
            <button type="submit" name ="submit" class="btn btn-primary">Submit</button>
            <p style = "display = block;"><?php echo $error; ?></p>
          </form>
        </div>
    </body>
</html>
