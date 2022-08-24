<?php
require_once('header.php');

if(isset($_POST['change_btn'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    

    $admin_id = $_SESSION['admin_logedin'][0]['id'];

    $statement = $pdo->prepare("SELECT password FROM admin WHERE id=?");
    $statement->execute(array($admin_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $db_password = $result[0]['password'];


    if(empty($current_password)){
        $error = "Current password is Required!";
    }
    else if(empty($new_password)){
        $error = "New password is Required!";
    }
    else if(empty($confirm_new_password)){
        $error = "Confirm New password is Required!";
    }
    else if($new_password != $confirm_new_password ){
        $error = "New Password and Confirm New Password Does't Match!";
    }
    else if(SHA1($current_password) != $db_password ){
        $error = "Current Password is Wrong!";
    }
    else{ 
        $new__password = SHA1($confirm_new_password);

        $stm=$pdo->prepare("UPDATE admin SET password=? WHERE id=?");
        $stm->execute(array($new__password,$admin_id));
        $success = "Password change Successfully!";
        
    }

}

?>


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">manage post</h6>
                <?php if(isset($error)) :?>
                <div class="alert alert-danger"><?php echo $error;?></div>
                <?php endif;?>
                <?php if(isset($success)) :?>
                <div class="alert alert-success"><?php echo $success;?></div>
                <?php endif;?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="c_password">Current Password</label>
                        <input type="password" name="current_password" class="form-control" id="c_password" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password">new password</label>
                        <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password">new password</label>
                        <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password" placeholder="Password">
                    </div>
                    <button type="submit" name="change_btn" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php');?>