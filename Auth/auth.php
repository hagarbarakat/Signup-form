<?php
    include("../Database/db.php");
    include("../Model/user.php");
    include("../Validation/validation.php");

    /*if(isset($_GET['logout'])){
        $auth = new auth();
        $auth->logout();
    }*/
    class auth{
        public $login_session;
        public $db_connection;
        public $validation;

        public function __construct(){
            $this->db_connection = new database_helper();
            $this->validation = new Validation();
        }
        
        public function loginbyEmail($arr){
            $sql = $this->db_connection->getUserbyEmail($arr["email"]);
            $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
            //$user = new user($row["username"], $row["email"], $row["phone"], $row["password"]);
            if($sql !== FALSE && password_verify($arr["password"], isset($row['password']))) {
                $_SESSION['login_user'] = $row['username'];
                $_SESSION['login_time'] = time();
                header("location: welcome.php");
            }
            else {
                $error = "Check your credentials.";
                return $error;
            }        
        }

        function signup($arr){
            $error = "";
            $validatedCredentials = $this->validation->validateSignUp($arr["name"],$arr["email"],$arr["password"], $arr["phone"]);
            if ($validatedCredentials !== TRUE) {
                $error = $validatedCredentials;
                return $error;
            }
            $psswd = PASSWORD_HASH($arr["password"], PASSWORD_DEFAULT);
            $result = $this->db_connection->insert($arr["name"], $arr["email"], $psswd, $arr["phone"]);
            if ($result === TRUE) {
                $_SESSION['login_user'] = $arr['name'];
                $_SESSION['login_time'] = time();
                header("location: welcome.php");
            }
            else {
                $error = "Insertion error: either username is already used or email is already used.";
                return $error;
            }
        }

        function checkSession(){

            if(!isset( $_SESSION['login_user'] ) || time() - $_SESSION['login_time'] > 60)
            {
                header("location:login.php");
               die();
            }
            else
            {
               // uncomment the next line to refresh the session, so it will expire after ten minutes of inactivity, and not 10 minutes after login
               //$_SESSION['login_time'] = time();
               $sql = $this->db_connection->getUserbyName($_SESSION['login_user']);               
               $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
               $this->login_session = new user($row["username"], $row["email"], $row["phone"], $row["password"]);
            }
            
        }

        function logout(){
            session_start();
            if(session_destroy()) {
                header("Location: ../Views/login.php");
            }
        }

        function getLoginSession(){
            $this->checkSession();
            return $this->login_session->getName();
        }
    }
?>