<?php error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('header.php');

if(isset($_POST['submit'])){
    $topic = $_POST['topic'];
    if($topic == 'add_new'){
        $topic = $_POST['new_topic'];
    }
    $title = $_POST['title'];
    $about = $_POST['about'];
    $photo = $_FILES['photo'];
    $photo_name = $_FILES['photo']['name'];


    if(empty($topic)){
        $error = "topic is Required!";
    }
    else if(empty($title)){
        $error = "title is Required!";
    }
    else if(empty($about)){
        $error = "about is Required!";
    }
    else if(empty($photo_name)){
        $error = "photo is Required!";
    }  
    else{
       
        $target_dir = "img/admin-photo/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $extension= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
            $error = "Photo Must be jpg or png or jepg!";
        }
        else{
            $photo_num =rand(99,9999);
            $temp_name =$_FILES["photo"]["tmp_name"];
            $final_path =$target_dir ."user_id_".$photo_num.".".$extension;
            $uploadSt = move_uploaded_file($temp_name, $final_path);    
            if($uploadSt){
                $insert =$pdo->prepare('INSERT INTO managepost(topic,title,about,photo) VALUES (?,?,?,?)');
                $insertStatus = $insert->execute(array($topic,$title,$about,$final_path));
                if($insertStatus == true){
                    $success = 'Post Insert Successfully!';                   
                }
                else{
                    $error = 'Insert failed!';           
                } 
            }
            else{
                $error = 'Photo upload failed !';
            }
        }
            
      
         
    }

}

?>


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">manage Post</h6>
                <?php if(isset($error)) :?>
                <div class="alert alert-danger"><?php echo $error;?></div>
                <?php endif;?>
                <?php if(isset($success)) :?>
                <div class="alert alert-success"><?php echo $success;?></div>
                <?php endif;?>
                <form method="POST" action="" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="topic">Topic</label>
                       
                        <select name="topic" class="form-select" id="topic"
                            aria-label="Floating label select example">
                            <option selected>Open this select menu</option>
                            <option value="add_new">add new</option>
                            <?php 
                                $sql = $pdo->prepare('SELECT topic FROM managepost');
                                $sql->execute();
                                $topicCount = $sql->rowCount();
                                echo $topicCount;
                                if($topicCount != 0) :
                                $topicAll = $sql->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($topicAll as $key) :  
                            ?>
                          
                                <option value="<?php echo $key['topic'] ;?>"><?php echo $key['topic'] ;?></option>
                           <?php endforeach; endif; ?>
                            
                        </select>
                    </div>
                    <div class="mb-3 " id="add-new-topic" style="display:none">
                        <label for="new_topic">Add Topic</label>
                        <input type="text" name="new_topic" class="form-control" id="new_topic" placeholder="Type a topic">
                    </div>
                    <div class="mb-3">

                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Post title">
                    </div>
                    <div class="mb-3">
                        <label for="about">About</label>
                        <textarea name="about" id="about" class="form-control" cols="20" rows="5"></textarea>                       
                    </div>
                    <div class="mb-3">
                        <label for="photo">Photo</label>
                        <input class="form-control bg-dark" name="photo" id="photo" type="file" placeholder="Photo">
                    </div>
                    <img style="width:100%; max-height:300px;height:100%;object-fit:cover;" src="" id="image-preview" alt="" srcset="">
                    <button type="submit" name="submit" class="btn btn-primary mt-2">submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php');?>
<script>
    $('#topic').change(function(){
        var topicVal = $(this).val();
        if(topicVal == 'add_new'){
            $('#add-new-topic').show();
        }
        else{
            $('#add-new-topic').hide();
        }
        console.log(topicVal);
    });

    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview').hide();
                $('#image-preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
            }

            $("#photo").change(function() {
                readURL(this);
            });

</script>