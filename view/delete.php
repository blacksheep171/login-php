<?php 
require "../model/config.php";
require "../model/user.php";
session_start();
if(isset($_SESSION['user_name'])){
    $con = Config::connect();
    $id = getCurrentId();
    if(delete($con,$id)){
        header("Location:index.php");
    }
} else {
    echo "<script>alert('can not delete !');document.location='index.php'</script>";
}