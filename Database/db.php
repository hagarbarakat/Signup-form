<?php
 class database_helper
 {
   public $connection;

   public function __construct(){
       $this->connection = mysqli_connect("localhost", "root","",'new_admin') or die("Unable to connect");
   }

   function insert($username, $myemail, $mypassword, $myphone){
        $sql = "INSERT INTO users (username, password, email, phone) VALUES ('$username','$mypassword', '$myemail', '$myphone')";
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
    
 }
?>