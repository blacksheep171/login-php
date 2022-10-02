<?php
    require "../model/connection.php";
    require "../model/user.php";
    $message = [];
    if(isset($_POST['save'])) {
        $name = $_POST['name'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = strip_tags($_POST['password']);
        $password_confirm = strip_tags($_POST['password_confirm']);
        $role = $_POST['role']; 
        if(validated()){
            $message = array_merge(validated(),$message);      
        }
        
        if(empty($message)) {

            try {
                $select_stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email ");
                $select_stmt->execute([':email' => $email]);
                $data = $select_stmt->fetch();
             
                if(isset($data['email']) == $email) {
                            $message[] = 'Email already exists';
                } else {
                    $password_hash = md5($password);
                    $data = [
                        ':name' => $name,
                        ':email' => $email,
                        ':password' => $password_hash,
                        ':role' => $role
                    ];

                    $sql = "INSERT INTO `user` (`name`, `email`, `password`, `role`) VALUES (:name, :email, :password, :role)";
                    $stmt= $pdo->prepare($sql);
                    if ($stmt->execute($data)) {
                        header("Location:index.php?msg=".urlencode('Click the verification email'));
                    }
                }
            } catch (PDOException $e) {
                $pdoError = $e->getMessage();
            }   
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
	<title>Register New Account</title>
</head>
<body>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Register New Account</h2>
			</div>
            <?php if(isset($message)){
                foreach($message as $error) {
                    echo "<p class = 'small text-danger'>".$error."</p>";
                }
            }
            ?>
            <form action="" method="post">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Confirmation Password:</label>
                        <input type="password" name="password_confirm" class="form-control" id="confirmation_pwd" required>
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="role" aria-label="select">
                            <option selected>Choose your role</option>
                            <option id="role1" value="DEV">DEV</option>
                            <option id="role2" value="LEAD">LEAD</option>
                            <option id="role3" value="MANAGER">MANAGER</option>
                        </select>
                    </div>
                    
                    <div class="form-group mx-sm-3 mb-5">
                        <div class = "row">
                            <div class = "col-1  my-1">
                                <input type="submit" class="btn btn-success" name="save" value="Register"/>
                            </div>
                            <div class = "col-3  my-1" style="text-align:right">
                                 <label>Already have an Account</label>
                            </div>
                            <div class = "col-1  my-1">
                            <a href="login.php" class="btn btn-link">Login Instead</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>     
		</div>
	</div>
</body>
</html>