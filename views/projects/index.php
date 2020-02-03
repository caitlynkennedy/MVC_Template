
<?php
require_once("../../controllers/includes.php");

$title = "My Profile";

require_once("../elements/header.php");
require_once("../elements/nav.php");

?>
<div class="container my-5 pt-2 pb-5">
    <?php

    // Check if the id is set
    // if it is, get the user by id and pass data
    // else load current user
    if( !empty($_GET['id'])) {
        $project_id = $_GET['id'];
        $p_model = new Project;
        $project = $p_model->get_by_id($_GET['id']);
        $c_model = new Comment;
        ?>
   
        <div class="col-md-8 mx-auto card project-post my-5">
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
            </div
        
    
    <?php
    } else {
        $p_model = new project;
        $projects = $p_model->get_all();
    }

    ?>
    
</div>

<?php
require_once("../elements/footer.php")
?>