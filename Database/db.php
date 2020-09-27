<?php
 class database_helper
 {
   public $connection;

   public function __construct(){
       $this->connection = mysqli_connect("localhost", "root","",'new_admin') or die("Unable to connect");
   }

   function insert($username, $myemail, $mypassword, $myphone, $activationcode, $verified){
        $password = mysqli_real_escape_string($this->connection, $mypassword);
        $sql = "INSERT INTO users (username, password, email, phone, code, verified) VALUES ('$username','$password', '$myemail', '$myphone', '$activationcode', '$verified')";
        $result = mysqli_query($this->connection, $sql);
        return $result;
   }

   function getUserbyEmail($myemail){
        $sql = "SELECT * FROM `users` WHERE email = '$myemail'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
   }

   function getUserbyName($username){
        $sql ="SELECT * FROM users where username = '$username'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    function getActivationcode($username){
        $sql ="SELECT code FROM users where username = '$username'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }
    function setVerified($username){
        $sql = "UPDATE users SET verified = 1 WHERE username = '$username';";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }
    function checkverified($username){
        $sql = "SELECT verified from users where username = '$username'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }
 }
?>