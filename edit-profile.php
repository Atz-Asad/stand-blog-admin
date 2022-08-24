<?php
	require_once('header.php');
?>
<?php 
	

	$user_id = $_SESSION['admin_logedin'][0]["id"]; 

	$stm=$pdo->prepare("SELECT * FROM admin WHERE id=?");
	$stm->execute(array($user_id));
	$result = $stm->fetchAll(PDO::FETCH_ASSOC);

	$name=$result[0]["name"];
    $photo=$result[0]["photo"];

	// User details Update
	if(isset($_POST['save_change'])){
        $name = $_POST["name"];
        $photo_name = $_FILES["photo"]["name"];


        if(empty($name)){
            $error = "Name is required!";
        }       
        else{
            
			if(!empty($photo_name)){
				$target_dir = "img/admin-photo/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$extension= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
					$error = "Photo Must be jpg or png or jepg!";
				}
				else{
                    $photo_num =rand(99,9999);
					$temp_name =$_FILES["photo"]["tmp_name"];
					$final_path =$target_dir ."user_id_". $user_id.$photo_num.".".$extension;
					move_uploaded_file($temp_name, $final_path);    
				}
				
			}
			else{
				$final_path = admin('photo',$user_id);
			}
			// Update data
			$update = $pdo->prepare("UPDATE admin SET name=?,photo=? WHERE id=? ");
			$update->execute(array(
				$name,				
				$final_path,
                $user_id
			));
			$success = "profile update succesfully!";

        }
        
    }

?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Change Password</h6>
                <?php if(isset($error)) :?>
                <div class="alert alert-danger"><?php echo $error;?></div>
                <?php endif;?>
                <?php if(isset($success)) :?>
                <div class="alert alert-success"><?php echo $success;?></div>
                <?php endif;?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <input class="form-control" name="name" type="text" value="<?php echo $name ;?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="col-sm-3 col-form-label">Profile Photo</label>
                        <div class="col-12">
                            <?php if($photo != null) :?>
                            <div class="profile-photo">
                                <a target="_blank" href="<?php echo $photo ;?>"><img style="height:100px; width=auto;" src="<?php echo $photo ;?>" ></a>
                            </div>
                            <?php endif;?>
                            <mark><small>If won't change photo , skip the input field.</small></mark>
                            <input class="form-control mt-3" name="photo" type="file">
                        </div>
                    </div>
                    <button type="submit" name="save_change" class="btn btn-primary">Save Change</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php');?>
