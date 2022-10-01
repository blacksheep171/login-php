<?php 
session_start();
print_r($_SESSION['email']);
session_destroy();
header('Location: login.php');
?>