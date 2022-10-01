<?php 
require "../model/connection.php";


    function getCurrentId() {
        $id = '';
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
