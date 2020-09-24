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

        public function __construct(){
            $this->db_connection = new database_helper();
        }
        
        public function loginbyEmail($arr){

            $error = '';
            $validation = new Validation();
            $validateEmail = $validation->validateEmail($arr["email"]);
            if (!empty($validateEmail)) {
                $error = $validateEmail; 
            }
            else{
                $sql = $this->db_connection->getUserbyEmail($arr["email"]);
                $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
                //$user = new user($row["username"], $row["email"], $row["phone"], $row["password"]);
                // If result matched $myusername and $mypassword, table row must be 1 row	
                if($sql !== FALSE && password_verify($arr["password"], $row['password'])) {
                    $_SESSION['login_user'] = $row['username'];
                    $_SESSION['login_time'] = time();
                    header("location: welcome.php");
                }
                else {
                    $error = "Your Login Name or Password is invalid";
                }
            }        
            return $error;
        }

        function signup($arr){
            $error = "";
            // username and password sent from form 
            $validation = new Validation();
            $validatedEmail = $validation->validateEmail($arr["email"]);
            $validatedPhone = $validation->validatePhoneNumber($arr["phone"]);
            $validatedPassword = $validation->validatePassword($arr["password"]);
            if (empty($validatedEmail) && empty($validatedPhone) && empty($validatedPassword)) {
                $psswd = PASSWORD_HASH($arr["password"], PASSWORD_DEFAULT);
                $result = $this->db_connection->insert($arr["name"], $arr["email"], $psswd, $arr["phone"]);
                if ($result === TRUE) {
                    $_SESSION['login_user'] = $username;
                    $_SESSION['login_time'] = time();
                    header("location: welcome.php");
                }
                else {
                $error = "Username is already used";
                }
            }
            else{
                $error = $validatedEmail . $validatedPassword . $validatedPhone;
            }
            return $error;
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