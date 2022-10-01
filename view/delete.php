<?php 
require "../model/connection.php";
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE id =:id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $message = 'delete success';
} else {
    $message = 'delete failed';
}