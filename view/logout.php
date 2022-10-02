<?php 
session_start();
print_r($_SESSION['username']);
session_destroy();
header('Location: index.php');
?>