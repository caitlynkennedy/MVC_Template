 <?php
require_once("../controllers/includes.php");

 $title = "Home Page";

require_once("elements/header.php");
require_once("elements/nav.php");

?>

<body>
    


<div class="container my-5 pb-4">
    <?php
    // if the user_logged_in session variable is not set with a user ID
    if( empty($_SESSION['user_logged_in']) ){
        //show logged in form
        require_once("elements/sign-up-form.php");
    } else {
        ?>
        <div>
            <h1 class="col-sm-12 title mx-auto logo-font pt-5 text-light text-center"><?=APP_NAME?></h1>
        </div>
        <div class="row text-center">
            <h3 class="mx-auto text-light secondary-font">Share, Inspire, Invent</h3>
        </div>

    <?php

    //check for alerts
    if( !empty($_SESSION['errors']) && is_array($_SESSION['errors']) ) {
        foreach( $_SESSION['errors'] as $error ) {
            echo "<div class='alert alert-danger'>$error</div>";
        }

        unset($_SESSION['errors']);
    }
    
    ?>

    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card pink-outline my-5 z-index" id="shareProjectCard">
                <div class="card-header">
                    <h4 class=" secondary-font pt-2">Share New Idea</h4>
                </div>
                <div class="card-body">
                    <form action="/projects/add.php" method="post" enctype="multipart/form-data">
                        <img id="img-preview" class="w-100">
                        <div class="form-group custom-file">
                            <input id="file-with-preview" type="file" name="fileToUpload" class="custom-file-input" required>
                            <label class="custom-file-label secondary-font">Choose File</label>
                        </div>
                        <div class="form-group mt-3">
                            <input class="form-control" type="text" name="title" placeholder="Project Title" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="secondary-font form-control" name="description" placeholder="Project Description" required></textarea>
                        </div>
                        <div class="form-group text-right mb-1 mt-5">
                            <button type="submit" id="styled-btn" class="btn">Post Project</button>
                        </div>
                    </form>
                </div>
            </div> <!--End of shareProjectCard-->
            <hr id="that-hr" >
            <div class="row">
                <h3 class="mx-auto py-2 mt-3">Browse</h3>
            </div>
            
            <div id="projectFeed">
                <?php

                $p_model = new Project;
                $projects = $p_model->get_all();
                $c_model = new Comment; // get an instance of the comment model
                
                foreach($projects as $project) {
                    
                ?>

                    <div class="card project-post my-5">
                        <div class="card-header">
                            <h4 id="user-link" class="pt-2 no-link"><a href="/users/?id=<?=$project['user_id']?>"><?=$project['firstname'] . " " . $project['lastname']?></a>
                            <?php
                            if($project['user_id'] == $_SESSION['user_logged_in']) {
                                ?>
                                <span class="float-right">
                                    <small><a href="/projects/edit.php?id=<?=$project['id']?>"><i class="fas fa-edit text-dark"></i></a></small>
                                    <small><a href="/projects/delete.php?id=<?=$project['id']?>"><i class="fas fa-trash-alt text-dark"></i></a></small>
                                </span>

                                <?php
                            }
                            ?> </h4>
                        </div>
                        <div class="card-img-top">
                            <img src="<?=$project['file_url']?>"class="img-fluid" alt="">
                        </div>
                        <div class="card-body">
                            <h5><?=$project['title']?></h5>
                            <p><?=$project['description']?></p>
                            <p><small class="text-muted"><?=date("M d, Y", strtotime($project['date_uploaded']))?></small></p>
                        </div>
                        <div class="card-footer">
                            <?php
                            $love_class = 'far';
                            if( !empty($project['love_id'])) {
                                $love_class = 'fas';

                            }
                            ?>
                            <div class="project-meta">
                                <span class="love-btn float-left" data-project="<?=$project['id']?>">
                                    <i class="<?=$love_class?> fa-heart text-danger love-icon"></i>
                                    <span class="love-count"><?=$project['love_count']?></span>
                                </span>

                                <span class="float-right comment-btn">
                                    <i class="pb-3 far fa-comment"></i>
                                    <span class="comment-count"><?php
                                        echo $c_model->get_count($project['id']);
                                    ?></span>
                                </span>
                            </div>

                            
                            <div class="comment-loop">
                                <?php
                                $project_comments = $c_model->get_all_by_project_id($project['id']);
                                foreach($project_comments as $user_comment){
                                    $my_comment = ($user_comment['user_owns'] == "true") ? "my_comment" :"";
                                    ?>
                                    <div class="user-comment <?=$my_comment?>">
                                    
                                        <p><span class="font-weight-bold comment-username"><?=$user_comment['username']?>:</span> 
                                            <?=$user_comment['comment']?> 
                                            <?php
                                                if( $user_comment['user_id'] == $_SESSION['user_logged_in'] ){ ?>
                                                    <a data-id="<?=$user_comment['id']?>" class="delete-comment"><i class="fas fa-trash-alt float-right text-dark"></i></a>
                                                <?php
                                                }
                                            ?>
                                            
                                    </div>
                                    <?php
                                }
                                ?>

                            </div> <!-- END OF COMMENT LOOP -->
                            <hr>
                            <form class="comment-form" data-project="<?=$project['id']?>">
                                <input type="text" name="comment" placeholder="Write a comment..." class="mb-2 form-control comment-box">
                            </form>

                        </div>
                    </div>

                <?php
                }
            }



                ?>
            </div>


        </div>
    </div>


</div>
</body>

<?php
require_once("elements/footer.php")
?>