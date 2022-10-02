<?php
require "../model/connection.php";
require "../model/user.php";
session_start();
$message = [];
if(isset($_SESSION['username'])){
    $id = getCurrentId();
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id=:id");
    if ($stmt->execute(['id' => $id])) {
        $row = $stmt->fetch();
    } else {
        $message[] = "No data found";
    }

    if(isset($_POST['save'])) {
        $name = $_POST['name'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $role = $_POST['role'];
        if(validatedUpdate()){
            $message = array_merge(validatedUpdate(),$message);      
        }
        
        if(empty($message)) {
            try {
                $data = $pdo->query("SELECT * FROM user")->fetchAll();
                foreach($data as $key => $users){
                    if($users['email'] == $row['email']){
                        unset($data[$key]);
                    }
                }
                foreach($data as $key => $users){
                    if($users['email'] == $email){
                        $message[] = 'Email already exists';
                    }
                }
                if(empty($message)) {
                    
                    $data = [
                        ':name' => $name,
                        ':email' => $email,
                        ':role' => $role,
                        ':id' => $id
                    ];
                    $sql =  "UPDATE user SET `name` = :name, `email` = :email, `role` = :role WHERE `id` = :id ";
                    $stmt= $pdo->prepare($sql);
                    if ($stmt->execute($data)) {
                        echo "<script>alert('update successfully!');document.location='index.php'</script>";
                    }
                }
                
            } catch (Exception $e) {
                $pdoError = $e->getMessage();
            }
        }
    }  
} else {
    echo "<script>alert('can not update');document.location='index.php'</script>";
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
<title>Update Account</title>
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Update Your Account</h2>
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
                    <input type="text" name="name" value="<?= $row['name']?>" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email"  value="<?= $row['email']?>" class="form-control" id="email" required>
                </div>
            
                <!-- <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password"  value="" class="form-control" id="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmation Password:</label>
                    <input type="password" name="password_confirm"  value="" class="form-control" id="password_confirm" required>
                </div> -->
                <div class="form-group">
                    <select class="form-select" name="role"  value="<?php $result = $row['role']?>" aria-label="select">
                        <option selected>Choose your role</option>
                        <option id="role1"<?php if($result == 'DEV'){ echo ' selected="selected"'; } ?> value="DEV">DEV</option>
                        <option id="role2"<?php if($result == 'LEAD'){ echo ' selected="selected"'; } ?> value="LEAD">LEAD</option>
                        <option id="role3"<?php if($result == 'MANAGER'){ echo ' selected="selected"'; } ?> value="MANAGER">MANAGER</option>
                    </select>
                </div>
                
                <div class="form-group mx-sm-3 mb-5">
                    <div class = "row">
                        <div class = "col-1  my-1">
                            <input type="submit" class="btn btn-success" name="save" value="Update"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>     
    </div>
</div>
</body>
</html>