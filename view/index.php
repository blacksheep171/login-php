<?php 
    ob_start();
    session_start();
    include "../model/connection.php";

    if(isset($_SESSION['username'])){   
        echo "Welcome".$_SESSION['username'];
    } else {
        echo "No session";
    }
    $data = $pdo->query("SELECT * FROM user")->fetchAll();
    
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