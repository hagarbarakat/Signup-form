<?php
    class validation{

        function validateEmail($myemail){
            $error = "";
            if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid format and please re-enter valid email<br>"; 
            }
            return $error;
        }

        function validatePhoneNumber($myphone){
            $error = "";
            if(!preg_match("/^\d+$/", $myphone)) {
                $error = "Phonenumber must contain numbers only<br>";
            }
            return $error;
        }

        function validatePassword($mypassword){
            $error = "";
            if(!preg_match('/^(?=.*[^a-zA-Z]).{8,40}$/', $mypassword)){
                $error = "Password is less than 8 characters<br>";
            }
            return $error;
        }
        function validateName($username){
            $error = "";
            if(!preg_match("/^[\w ]*$/", $username)){
                $error = "Enter valid username<br>";
            }
            return $error;
        }

        function validateSignUp($username, $myemail, $mypassword, $myphone){
            $name = $this->validateName($username);
            $email = $this->validateEmail($myemail);
            $phone = $this->validatePhoneNumber($myphone);
            $password = $this->validatePassword($mypassword);
            if(empty($name) && empty($email) && empty($phone) && empty($password)){
                return TRUE;
            }
            return $name.$email.$phone.$password;
        }
    }
?>