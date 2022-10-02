<?php 
require "../model/connection.php";
require "../model/user.php";
session_start();
if(isset($_SESSION['username'])){
    $id = getCurrentId();
    $sql = "DELETE FROM user WHERE id =:id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    echo "<script>alert('delete successfully!');document.location='index.php'</script>";

} else {
    echo "<script>alert('can not delete !');document.location='index.php'</script>";
}