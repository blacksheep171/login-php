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
<title>Simple Login</title>
</head>
<body>
<div class="container">
    <div class="page-header">
        <nav class="navbar navbar-light d-flex justify-content-end" style="background-color: #e3f2fd;">
            <a href='index.php' class='navbar-brand'>Home</a>
            <?php if(isset($_SESSION['user_name']) && ($_SESSION['user_name'] != "")) {
                echo "
                <a href='profile.php?id=".$_SESSION['id']."' class='btn btn-link'>Welcome ".$_SESSION['user_name']."</a>
                <a href='logout.php' class='btn btn-primary'>Logout</a>
                ";
            } else {
            ?>
                <a href='login.php' class='btn btn-primary'>Login</a>
                <a href='register.php' class='btn btn-success'>Register</a>
            <?php } ?>
        </nav>
        