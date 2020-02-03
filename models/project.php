<?php

class Project extends DB {
  
    /*
    *   get_all()
    *   get all projects from database 
    *   @return array
    */

    public function get_all() {

        $user_id = (int)$_SESSION['user_logged_in'];

        if( !empty($_GET['search']) ) {
            $search_query = $this->params['search'];
            $sql_where = "WHERE projects.title LIKE '%$search_query%' 
                            OR CONCAT(users.firstname, '', users.lastname) LIKE '%$search_query%'
                            OR username LIKE '%$search_query%' ";
        } else {
            $sql_where = '';
        }

        $sql = "SELECT  projects.*, 
                        users.firstname, users.lastname, users.username,
                        loves.id AS love_id,
                        (SELECT COUNT(loves.id) FROM loves WHERE loves.project_id = projects.id) AS love_count
                FROM projects
                LEFT JOIN users
                ON projects.user_id = users.id
                LEFT JOIN loves
                ON projects.id = loves.project_id AND loves.user_id = $user_id 
                $sql_where
                ORDER BY projects.date_uploaded DESC";

        $projects = $this->select($sql);

        return $projects;
    }


    /*
    * get_by_id()
    * Get a project by ID
    @ param $id
    * @return array
    */

    public function get_by_id($id) {
        $id = (int)$id; // check that value is an integer

        $sql = "SELECT  projects.*,
                        users.firstname, users.lastname, users.username,
                        loves.id AS love_id,
                        (SELECT COUNT(loves.id) FROM loves WHERE loves.project_id = projects.id) AS love_count
                        FROM projects
                        LEFT JOIN users
                        ON projects.user_id = users.id
                        LEFT JOIN loves
                        ON projects.id = loves.project_id 
                    
                        WHERE projects.id = $id";

        $project = $this->select($sql)[0];

        return $project;

    }


    /*
    *   add()
    *   add new project to database 
    *   return null
    */

    public function add() {

        $title = $this->data['title'];
        $description = $this->data['description'];
        $user_id = (int)$_SESSION['user_logged_in'];
        $current_time = date( "Y-m-d H:i:s", time());

        // get the util class and use the file upload method of the Util class to upload our image file
        $util = new Util;
        $file_upload = $util->file_upload();
        $filename = $file_upload['filename'];

        if( $file_upload['file_upload_error_status'] == 0 ) {
            $sql = "INSERT INTO projects (title, description, date_uploaded, user_id, file_url) 
                    VALUES ('$title', '$description', '$current_time', '$user_id', '$filename')";

            $this->execute($sql);

        }

    }


    /*
    *   edit()
    *   edit a project in the database 
    *   @param $project_id
    *   @return void/null
    */
    public function edit($project_id) {
        $project_id = (int)$project_id;
        $this->check_ownership($project_id);

        // process form data and update database
        $title = $this->data['title'];
        $description = $this->data['description'];
        $current_user_id = (int)$_SESSION['user_logged_in'];

        // is there a new image
        if( !empty($_FILES['fileToUpload']['name'] ) ) {

            $util = new Util;
            $file_upload = $util->file_upload();
            $filename = $file_upload['filename'];

            if( $file_upload['file_upload_eror_status'] == 0) {

                // get the old file
                $old_filename = $this->get_by_id($project_id)['file_url'];

                // delete the old photo
                if( !empty($old_filename) ) {
                    if( file_exists(APP_ROOT . '/views' . $old_filename) ) {
                        unlink(APP_ROOT . '/views' . $old_filename);
                    }
                }

                $sql = "UPDATE projects 
                    SET title = '$title', description = '$description', file_url = '$filename'
                    WHERE id = $project_id AND user_id = $current_user_id";

                $this->execute($sql);
            }

            
        } else { // if no new image, just new text
            $sql = "UPDATE projects 
                    SET title = '$title', description = '$description' 
                    WHERE id = $project_id AND user_id = $current_user_id";

            $this->execute($sql);
        }
    }


    /*
    *   delete()
    *   delete a project
    *   @return void/null
    */
    public function delete() {

        $current_user_id = (int)$_SESSION['user_logged_in'];
        $project_id = (int)$_GET['id'];

        $this->check_ownership($project_id);

        $project_image = $this->get_by_id($project_id)['file_url'];
        if(!empty($project_image)) {
            if(file_exists(APP_ROOT . '/views' . $project_image)){
                unlink(APP_ROOT . '/views' . $project_image );
            }
        }

        $sql = "DELETE FROM projects WHERE id = $project_id AND user_id = $current_user_id";
        $this->execute($sql);

    }


    /*
    * check ownership
    * check if user is the owner of the prject
    * @param $project_id
    * @return boolean
    */

    public function check_ownership($project_id) {
        $project_id = (int)$project_id;

        $sql = "SELECT * FROM projects WHERE id = $project_id";
        $project = $this->select($sql)[0];

        if( $project['user_id'] == $_SESSION['user_logged_in']) {
            return true;
        } else {
            header('Location: /');
            exit;
        }
    }

}

?>