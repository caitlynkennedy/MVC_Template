<?php
require_once("../../controllers/includes.php");

if(!empty($_GET['id']) ) {

    $p_model = new Project; // start project model
    $project = $p_model->get_by_id($_GET['id']);

    if( !empty($_POST) ) {
        $p_model->edit($_GET["id"]);
        header('Location: /');
        exit;
    }

} else {
    header("Location: /");
    exit;
}

require_once('../elements/header.php');
require_once('../elements/nav.php');

?>

<div class="container my-5 pb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-4">
                <div class="card-header">
                    <h4 class="pt-2">Edit Project</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <img id="img-preview" class="w-100" src="<?=$project['file_url']?>">
                        <div class="form-group custom-file mt-3">
                            <input id="file-with-preview" type="file" name="fileToUpload" class="custom-file-input">
                            <label class="custom-file-label">Choose File</label>
                        </div>
                        <div class="form-group mt-3">
                            <input class="form-control" type="text" name="title" placeholder="Project Title" value="<?=$project['title']?>">
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control secondary-font" name="description" placeholder="Project Description"><?=$project['description']?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" id="styled-btn" class="btn">Update Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('../elements/footer.php');

?>