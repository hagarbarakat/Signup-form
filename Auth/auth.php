<?php
    include("../Database/db.php");
    include("../Model/user.php");
    include("../Validation/validation.php");
    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    /*if(isset($_GET['logout'])){
        $auth = new auth();
        $auth->logout();
    }*/
    class auth{
        public $login_session;
        public $db_connection;
        public $validation;
        public $mail;

        public function __construct(){
            $this->db_connection = new database_helper();
            $this->validation = new Validation();
            $this->mail = new PHPMailer();
        }
        
        public function loginbyEmail($arr){
            $sql = $this->db_connection->getUserbyEmail($arr['email']);
            $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
            if(!isset($row['password']) && empty($row['password'])){
                return "Database error";
            }
            //$user = new user($row["username"], $row["email"], $row["phone"], $row["password"]);
            if($sql !== FALSE && password_verify($arr['password'], $row['password'])) {
                $_SESSION['login_user'] = $row['username'];
                $_SESSION['login_time'] = time();
                if(empty($this->checkVerification($row['username']))){
                    header("location: verify.php");
                }
                else{
                    header("location: welcome.php");

                }
            }
            else {
                $error = "Check your credentials.";
                return $error;
            }        
        }

        function signup($arr){
            $error = "";
            $validatedCredentials = $this->validation->validateSignUp($arr['name'],$arr['email'],$arr['password'], $arr['phone']);
            if ($validatedCredentials !== TRUE) {
                $error = $validatedCredentials;
                return $error;
            }
            $activationcode=md5($arr["email"].time());
            $psswd = password_hash($arr['password'], PASSWORD_DEFAULT); 
            $result = $this->db_connection->insert($arr["name"], $arr["email"], $psswd, $arr["phone"], $activationcode, 0);
            if ($result !== TRUE) {
                $error = "Insertion error: either username is already used or email is already used.";
                return $error;
            }
            $this->sendVerification($arr['name'], $arr['email'], $activationcode);
            $_SESSION['login_user'] = $arr['name'];
            $_SESSION['login_time'] = time();
            header("location: verify.php");
        }

        function checkSession(){

            if(!isset( $_SESSION['login_user'] ) || time() - $_SESSION['login_time'] > 60)
            {
                header("location:login.php");
                die();
            }
            // uncomment the next line to refresh the session, so it will expire after ten minutes of inactivity, and not 10 minutes after login
            //$_SESSION['login_time'] = time();
            $sql = $this->db_connection->getUserbyName($_SESSION['login_user']);               
            $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
            $this->login_session = new user($row["username"], $row["email"], $row["phone"], $row['password']);
        
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

        function sendVerification($name, $email, $activationcode){
            $this->mail->IsSMTP();
            $this->mail->Mailer = "smtp";
            $this->mail->SMTPDebug  = 1;  
            $this->mail->SMTPAuth   = TRUE;
            $this->mail->SMTPSecure = "tls";
            $this->mail->Port       = 587;
            $this->mail->Host       = "smtp.gmail.com";
            $this->mail->Username   = "demo.mail9809@gmail.com";
            $this->mail->Password   = "o*pt&ion_$#%";
            $this->mail->IsHTML(true);
            $this->mail->AddAddress($email, "recipient-name");
            $this->mail->SetFrom("demo.mail9809@gmail.com", "");
            //$this->mail->AddReplyTo("hagarbarakat97@gmail.com", "reply-to-name");
            //$this->mail->AddCC("cc-hagarbarakat97@gmail.com", "cc-recipient-name");
            $this->mail->Subject = "Activation code";
            $content = "<b>Your activation code is ". $activationcode ."</b>";
            $this->mail->MsgHTML($content); 
            if(!$this->mail->Send()) {
            echo "Error while sending Email.";
            var_dump($this->mail);
            } else {
            echo "Email sent successfully";
            }
        }

        function verifying($activationcode, $username){
            $sql = $this->db_connection->getActivationcode($username);
            $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
            if($sql === FALSE){
                return "Database error";
            }
            if($activationcode !== $row["code"]){
                return "Kindly check your code";
            }
            $result = $this->db_connection->setVerified($username);
            if($result === FALSE){
                return "Database error";
            }
            return TRUE;             
        }
        function checkVerification($username){
            echo $username;
            $result = $this->db_connection->checkverified($username);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            if($result === FALSE){
                return "Database error.";
            }
            echo $row['verified'];
            if(empty($row['verified'])){
                return FALSE;
            }
            return TRUE;
        }
    }
?>