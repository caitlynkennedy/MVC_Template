<?php
 require_once("../../controllers/includes.php");
 

    $users_profile = null;
    if(isset($_GET['id'])){
        $u = new User;
        $users_profile = $u->get_by_id($_GET['id']);
    }




  $title = "My Profile";
 
 require_once("../elements/header.php");
 require_once("../elements/nav.php");
 
 

 ?>
 <div class="container mt-3 mb-5 pb-4">
    <div class="row mb-4">
        <div class="card col-md-6 mx-auto my-5">

        <?php
        // my profile
        // There's no id in the url, so show the logged in users profile for editting.
        if(!isset($_GET['id']) || $_GET['id'] === $current_user['id']){

    
            ?>
            <h2 class="mt-5 mb-5 card-title text-center">My Profile</h2>
            <div class="img-container m-auto">
                <img src="<?=$current_user['profile_pic']?>" class="img-container" id="img-preview" alt="">
            </div>
            <div class="mx-5 text-left font-weight-bold text-capitalize">
                <p class="mt-4 mb-2"><strong>Name: </strong><?=$current_user['firstname']. " " . $current_user['lastname'];?>
                <p class="my-2"><strong>Email: </strong><?=$current_user['email']?></p>
                <p class="my-2"><strong>Username: </strong><?=$current_user['username']?></p>
                <p class="mt-2 mb-4"><strong>Bio: </strong><?=$current_user['bio']?></p>
                <p>
                    <a id="styled-btn" class="btn float-right mb-5" href="/users/edit.php">Edit Profile</a>
                </p>           
            </div>
            <?php
        } else {
            // users profile
            ?>
            <h2 class="mt-5 mb-5 card-title text-center"><?=$users_profile['firstname'] ." ". $users_profile['lastname']?></h2>
            <div class="img-container m-auto">
                <img src="<?=$users_profile['profile_pic']?>" class="img-container" id="img-preview" alt="">
            </div>
            <div class="mb-4 mx-5 text-left font-weight-bold text-capitalize">
                <p class="mt-4 mb-2"><strong>Name: </strong><?=$users_profile['firstname']. " " . $users_profile['lastname'];?></p>
                <p class="my-2"><strong>Email: </strong><?=$users_profile['email']?></p>
                <p class="my-2"><strong>Username: </strong><?=$users_profile['username']?></p>
                <p class="mt-2 mb-4"><strong>Bio: </strong><?=$users_profile['bio']?></p>
                        
            </div>


            <?php
        }
        ?>



        </div>
    </div>
 </div>

 <?php
require_once("../elements/footer.php");
 ?>