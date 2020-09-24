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
            if(!is_numeric($myphone)) {
                $error .= "Phonenumber must contain numbers only<br>";
            }
            return $error;
        }

        function validatePassword($mypassword){
            $error = "";
            if(strlen($mypassword) < 8){
                $error .= "Password is less than 8 characters<br>";
            }
            return $error;
        }
        function validateName($username){
            //TODO: validate name by regex
        }
    }
?>