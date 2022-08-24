
<?php require_once('header.php');
    $user_id = $_SESSION['admin_logedin'][0]["id"]; 

    $stm=$pdo->prepare("SELECT * FROM admin WHERE id=?");
    $stm->execute(array($user_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $name=$result[0]["name"];
    $photo=$result[0]["photo"];

?>
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Profile</h6>
                <table class="table">
                    <tr>
                        <td><b>Name:</b></td>
                        <td><?php echo $name ;?></td>
                    </tr>
                    <tr>
                        <td><b>Profile:</b></td>
                        <td>
                        <?php if($photo != null) :?>
                        <img style=" height:100px;width:auto;" src="<?php echo $photo;?>"></span></a>
                        <?php else :?>
                        <img alt="" src="assets/images/testimonials/pic3.jpg" width="32" height="32"></span></a>
                        <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="edit-profile.php" class="btn btn-warning">Edit Profile</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php');?>