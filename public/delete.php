<?php 
require "../model/connection.php";
require "../model/user.php";
// if(isset($_SESSION['username'])){
    $id = getCurrentId();
    

    $sql = "DELETE FROM user WHERE id =:id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    // $message[] = 'delete success';
    header("Location:index.php");
// } else {
//     echo  'delete failed';
// }