<?php 
    session_start();
    include("../Auth/auth.php");
    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    $arr = array('email'=>$_POST['email'], 'password'=>$_POST['password']);
    $auth = new auth();
    $error = $auth->loginbyEmail($arr);
    }
 ?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
            <a href="signup.php" style="display: block; margin-bottom: 1%;">Create an account?</a>
            <button type="submit"name= "submit" class="btn btn-primary">Submit</button>
            <p><?php echo $error; ?></p>
          </form>
        </div>
    </div>
    </body>
</html>