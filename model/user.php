<?php
include_once "../model/config.php";

    function getCurrentId() {
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        return $id;
    }

    function create($con,$name,$email,$password,$role){
        try{
            $stmt = $con->prepare("INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, :role)");
            $data = [
                ':name' => $name,
                ':email' => $email,
                ':password' => md5($password),
                ':role' => $role,
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    function checkLogin($con,$email,$password){
        try {
            $stmt = $con->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
            $data = [
                ':email' => $email,
                ':password' => md5($password)
            ];
            $stmt->execute($data);
            if($stmt->rowCount() == 1) {
                $result = $stmt->fetch();
                return $result;
            } else {
                return false;
            }
        
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    function index($con){
        try {
            $stmt = $con->prepare("SELECT * FROM user");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
    
    function getUser($con,$id){

        try{
            $stmt = $con->prepare("SELECT * FROM user WHERE id = :id");
            $data = [
                ':id' => $id
            ];
            $stmt->execute($data);
            $data = $stmt->fetchAll();
            if($stmt->rowCount() == 1) {
                return $data;
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        } 
    }

    function update($con,$id,$name,$email,$role){
        try {
            $stmt = $con->prepare("UPDATE user SET name = :name, email = :email, role = :role WHERE id = :id");
            $data = [
                ':name' => $name,
                ':email' => $email,
                ':role' => $role,
                ':id' => $id
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    function delete($con,$id){
        try{
            $stmt = $con->prepare("DELETE FROM user WHERE id = :id");
            $data = [':id' => $id];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
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
        $errorMessages = [];

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if(empty($name)){
                $errorMessages[] = "Name required";
            }
        }
        if(isset($_POST['email'])){
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            if(empty($email)){
                $errorMessages[] = "Email required";
            }
        }
        if(isset($_POST['password']) && isset($_POST['password_confirm'])){
            $password = strip_tags($_POST['password']);
            $passwordConfirm = $_POST['password_confirm'];

            if(empty($password)){
                $errorMessages[] = "Password required";
            } else if(strlen($password) < 6 ){
                $errorMessages[] = "Must be at least 6 characters";
            }
            if(empty($passwordConfirm)){
                $errorMessages[] = "Password required";
            } else if($password !== $passwordConfirm) {
                $errorMessages[] = "Confirm password not correct";
            }
        }
        if(isset($_POST['role'])){
            $role = $_POST['role'];
            if(!checkRole($role)){
                $errorMessages[] = "Please choose your role";
            }
        }
        return $errorMessages;
    }