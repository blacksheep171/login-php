<?php 
    include "../model/connection.php";

    ob_start();
    session_start();

    if(isset($_SESSION['username'])){
        header("Location:index.php");
    }
    $data = $pdo->query("SELECT * FROM user")->fetchAll();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Simple CURD with login PHP</title>
</head>
<body>
<div class="container">
<div class="page-header">
            <nav class="navbar navbar-light d-flex justify-content-end" style="background-color: #e3f2fd;">
                <?php if(isset($_SESSION['username']) && ($_SESSION['username'] != "")) {
                    echo "
                    <a href='#' class='btn btn-link'>Hello ".$_SESSION['username']."</a>
                    <a href='logout.php' class='btn btn-primary'>Logout</a>
                    ";
                } else {
                ?>
                    <a href='login.php' class='btn btn-primary'>Login</a>
                    <a href='register.php' class='btn btn-success'>Register</a>
                <?php } ?>
            </nav>
            
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">User List</h2>
        </div>
        <div class="col-12">
            <table class="table table-bordered table-striped" style="margin-top:20px;">
                <thead>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        if(!empty($data)) {
                        foreach($data as $row){
                            echo "
                                <tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['name']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['role']."</td>
                                    <td>
                                        <a href='update.php?id=".$row['id']."' class='btn btn-success btn-sm'>Edit</a>
                                        <a href='delete.php?id=".$row['id']."' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>
                            ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>