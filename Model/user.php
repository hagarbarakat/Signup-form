<?php
    class user
    {
        private $name;
        private $email;
        private $phone;
        private $password;

        function __construct($name, $email, $phone, $password) {
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->password = $password;
        }
        
        function getName(){
            return $this->name;
        }
        function setName($name){
            $this->name = $name;
        }

        function getEmail(){
            return $this->email;
        }
        function setEmail($email){
            $this->email = $email;
        }

        function getPhone(){
            return $this->phone;
        }
        function setPhone($phone){
            $this->phone = $phone;
        }

        function getPassword(){
            return $this->password;
        }
        function setPassword($password){
            $this->password = $password;
        }

    }
    