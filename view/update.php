<?php
require "../model/config.php";
require "../model/user.php";
session_start();
if(isset($_SESSION['user_name'])){
    $message = [];
    $con = Config::connect();
    $id = getCurrentId();
    $current_user = getUser($con,$id);
    $row = $current_user[0];
    if(isset($_POST['save'])) {
        $name = $_POST['name'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $role = $_POST['role'];
        if(validated()){
            $message = array_merge(validated(),$message);
        }
        if(empty($message)){
            if(update($con,$id,$name,$email,$role)){
                header("Location:index.php");
            } else {
                $message[] = "update failed! Please try later.";
            }
        }
    } 
} else {
    echo "<script>alert('can not update !');document.location='index.php'</script>";
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
