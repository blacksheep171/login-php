<?php 
require "../model/connection.php";

    function getCurrentId() {
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        return $id;
    }

    function checkRole($role) {
        $roleList = array('DEV','LEAD','MANAGER');
        
        if(in_array($role,$roleList)){
            return true;
        } else {
            return false;
        }
    }

    function validated(){
        $name = '';
        $email = '';
        $role = '';
        $password = '';
        $password_confirm = '';
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if(isset($_POST['email'])){
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }
        if(isset($_POST['role'])){
            $role = $_POST['role'];
        }
        if(isset($_POST['password'])){
            $password = strip_tags($_POST['password']);
        }
        if(isset($_POST['password_confirm'])){
            $password_confirm = $_POST['password_confirm'];
        }
        $errorMessages = [];

        if(empty($name)){
            $errorMessages[] = "Name required";
        }
        if(empty($email)){
            $errorMessages[] = "Email required";
        }
        if(empty($password)){
            $errorMessages[] = "Password required";
        }
        if(!checkRole($role)){
            $errorMessages[] = "Please choose your role";
        }
        if(strlen($password) < 6 ){
            $errorMessages[] = "Must be at least 6 characters";
        }
        if($password !== $password_confirm) {
            $errorMessages[] = "Confirm password not correct";
        }
        return $errorMessages;
    }

    function validatedUpdate(){
        $name = '';
        $email = '';
        $role = '';
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if(isset($_POST['email'])){
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }
        if(isset($_POST['role'])){
            $role = $_POST['role'];
        }

        $errorMessages = [];
        
        if(empty($name)){
            $errorMessages[] = "Name required";
        }
        if(empty($email)){
            $errorMessages[] = "Email required";
        }
        if(!checkRole($role)){
            $errorMessages[] = "Please choose your role";
        }
        return $errorMessages;
    }
    function validatedLogin(){
        $email = '';
        $password = '';
        if(isset($_POST['email'])){
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }
        if(isset($_POST['password'])){
            $password = $_POST['password'];
        }

        $errorMessages = [];
        
        if(empty($email)){
            $errorMessages[] = "Email required";
        }
        if(empty($password)){
            $errorMessages[] = "Password required";
        }
        return $errorMessages;
    }