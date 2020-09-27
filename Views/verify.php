<?php
     session_start();
     include("../Auth/auth.php");
     $error = "";
     if($_SERVER["REQUEST_METHOD"] == "POST") {
       $auth = new Auth();
       $error = $auth->verifying($_POST['verify'], $_SESSION["login_user"]);
       if($error === TRUE){
        header("location: welcome.php");
       }
     }
?>

<html>
    <head>
    <meta charset="utf-8">
    <title>Verify</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div style="margin-left: 2%;" >
        <h1>Verify your account</h1>
        <div style="width: 50%;">
        <form action="" method="POST">
            <div class="form-group">
              <label for="exampleInputverify1">Verification code</label>
              <input type="text" name="verify" class="form-control" id="exampleInputverify" aria-describedby="verifyHelp">
            </div>
            <button type="submit"name= "submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
    </body>
</html>