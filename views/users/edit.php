<?php
 require_once("../../controllers/includes.php");


 // if the for was submitted
 if( !empty($_POST) ) {
     $user->edit();
     header("Location: /users/");
     exit;
 }
 
  $title = "Editing " .$current_user['username'];
 
 require_once("../elements/header.php");
 require_once("../elements/nav.php");
 
 

 ?>
 <div class="container my-5 pb-5">
    <div class="row mb-4">

            
    
        <div class="card col-md-6 mx-auto my-4">
                <h2 class=" mt-5 mb-4 card-title text-center">Edit Profile</h2>
            
            <div class="img-container m-auto">
                <img class="card-img-center" id="img-preview" src="<?=$current_user['profile_pic']?>" alt="">

            </div>

            <form class="mt-4" method="post" enctype="multipart/form-data">
                <div class="form-group custom-file mb-4 overflow-hidden">
                            <input id="file-with-preview" type="file" name="fileToUpload" class="custom-file-input overflow-hidden">
                            <label class="custom-file-label secondary-font">Choose File</label>
                        </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?=$current_user['username']?>" required>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?=$current_user['firstname']?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?=$current_user['lastname']?>" required>
                </div>
            
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea type="text" id="bio" name="bio" class="form-control secondary-font"> <?=$current_user['bio']?></textarea>
                </div>
                <hr>
                <h4 class="my-4">Change Password</h4>
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="" >
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="" >
                </div>
                <div class="form-group">
                    <label for="password">Confirm New Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="" >
                </div>


                <div class=" my-4 text-right">
                    <button type="submit" id="styled-btn" class="btn">Update</button>
                </div>
            </form>

        </div>
    </div>
 </div>

 <?php
require_once("../elements/footer.php");
 ?>