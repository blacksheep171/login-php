<?php

include "../model/connection.php";
include "../model/user.php";

ob_start();
session_start();
if(isset($_SESSION['username'])){
    header("Location:index.php");
}
    if(isset($_POST['login']) && ($_POST['login'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        
        if(validatedLogin()){
            $message = array_merge(validatedLogin(),$message);
        }
        $data = [
            ':email' => $email,
            ':password' => $password
        ];
        $stmt = $pdo->prepare("SELECT * FROM user WHERE `email` = :email AND `password` = :password ");
        $stmt->execute($data);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data = $stmt->fetchAll();

        if(!empty($data)) {
            $data_username = $data[0]['name'];
            $data_email = $data[0]['email'];
        }
       
        if(!empty($data_email)) {
            $_SESSION['username'] = $data_username;
            header("Location:index.php");
        } else {
            $message[] = "Login failed. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<title>Login Form</title>
</head>
<body>
	<div class="container">
        <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Login Form</h2>
                </div>
                <?php if(isset($message)){
                    foreach($message as $error) {
                        echo "<p class = 'small text-danger'>".$error."</p>";
                    }
                }
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="form-group mx-sm-3 mb-5">
                            <div class = "row">
                                <div class = "col-1 ">
                                <input type="submit" class="btn btn-primary" name="login" value="Login"/>
                                </div>
                                <div class = "col-3" style="text-align:right">
                                    <label>Or Create New Account</label>
                                </div>
                                <div class = "col-1">
                                <a href="register.php" class="btn btn-success">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>     
            </div>
        </div>
    </div>
</body>
</html>