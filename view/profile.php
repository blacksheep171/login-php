<?php 
    ob_start();
    session_start();

    include_once "../model/config.php";
    include_once "../model/user.php";
    if(isset($_SESSION['user_name'])){
        $con = Config::connect();
        $user_id = getCurrentId();
        if($user_id){
            $data = getUser($con,$user_id);
        } else {
            $data = false;
        }
    } else {
        $data = false;
    }
?>
    <?php include "../view/header.php"; ?>
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
                </thead>
                <tbody>
                    <?php
                        if(!empty($data)) {
                            echo "
                                <tr>
                                    <td>".$data[0]['id']."</td>
                                    <td>".$data[0]['name']."</td>
                                    <td>".$data[0]['email']."</td>
                                    <td>".$data[0]['role']."</td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>