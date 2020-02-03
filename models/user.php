<?php
// define the class of User
class User extends DB {

     /*
    *  get_all()
    *  Get all users data from the database by ID
    *  
    *  @returns array
    */
    public function get_all(){
        if( !empty($_GET['search']) ) {
            $search_query = $this->params['search'];
            $search_query = str_replace('@', '', $search_query);
            $sql_where = "WHERE users.username LIKE '%$search_query%' 
                         OR users.firstname LIKE '%$search_query%'
                         OR users.lastname LIKE '%$search_query%' ";
        } else {
            $sql_where = '';
        }

        $sql = "SELECT * FROM users $sql_where";
        $user_results = $this->select($sql);

        foreach($user_results as $key => $user) {
            $user_results[$key]['title'] = $user['firstname'] . " " . $user['lastname'];
        }

        return $user_results;
    }


    /*
    *  get_by_id()
    *  Get a users data from the database by ID
    *   
    *  @params $user_id
    *  @returns array
    */

    public function get_by_id($user_id){
        $user_id = (int)$user_id;
        $sql = "SELECT * FROM users WHERE id = '$user_id'";
        $user = $this->select($sql)[0];

        return $user;
    }

    /*
    *  exists()
    *  Checks is the user already exists in the database
    *
    *  @returns array
    */

    public function exists() {
        if(APP_DEBUG) echo 'exists()<br>';
        // Check the database to see if the user exists
        $username = $this->data['username'];
        $email = $this->data['email'];

        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";

        $user = $this->select($sql);
        
        return $user;

    }

    /*
    *  add()
    *  Adds new user to the database
    *
    *  @returns int
    */
    public function add(){
        $username = $this->data['username'];
        $email = $this->data['email'];
        $firstname = $this->data['firstname'];
        $lastname = $this->data['lastname'];
        $bio = $this->data['bio'];
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        $sql = "INSERT INTO 
                 users (username, email, firstname, lastname, bio, password) 
                VALUES ('$username', '$email', '$firstname', '$lastname', '$bio', '$password')";

        $new_user_id = $this->execute_return_id($sql);

       return $new_user_id;

    }

     /*
    *  edit()
    *  edit the current user
    *
    *  @returns null
    */
    public function edit() { // storing some variables
        $id = (int)$_SESSION['user_logged_in'];
        $username = $this->data['username'];
        $firstname = $this->data['firstname'];
        $lastname = $this->data['lastname'];
        $bio = $this->data['bio'];
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        if( !empty($_FILES['fileToUpload']['name']) ) { // check if new file was submitted

            $util = new Util;
            $file_upload = $util->file_upload(); // upload the new file
            $filename = $file_upload['filename'];

            if( $file_upload['file_upload_error_status'] == 0) {
                // get the old image 
                $old_profile_image = $this->get_by_id($id)['profile_pic'];

                $sql = "UPDATE users SET profile_pic = '$filename' WHERE id = $id";

                $this->execute($sql);

                // delete the old image
                if( !empty($old_profile_image) ) {
                    if( file_exists(APP_ROOT. "/views" . $old_profile_image)) {
                        unlink(APP_ROOT. "/views" . $old_profile_image);
                    }
                }
            }

        }
            
        if(  $_POST['password'] == "") {
            
            $sql = "UPDATE users
            SET username = '$username', firstname = '$firstname', lastname = '$lastname', email = '$email', bio = '$bio'
            WHERE id = $id";
            
        } else {
           
            $sql = "UPDATE users SET username = '$username', firstname = '$firstname', lastname = '$lastname', email = '$email', bio = '$bio', password = '$password' WHERE id = $id";
        }
        
        $this->execute($sql);
    }


    /*
    *  login()
    *  logs in the user
    *
    *  @returns null
    */
    public function login() {

        $_SESSION = array(); // empty the session first to start fresh

        $username = $this->data['username'];
        $sql = "SELECT * FROM users WHERE username = '$username' OR  email = '$username' LIMIT 1";

        $user = $this->select($sql)[0];

        if( password_verify( $_POST['password'], $user['password'] ) ) {

            $_SESSION['user_logged_in'] = $user['id'];

            // if remember is set, set the cookie for user_logged_in
            if( !empty($_POST['remember'])) {
                setcookie('user_logged_in', $user['id'], time() + (1 * 24 * 60 * 60), "/");
            }
        } else {
            $_SESSION['login_attempt_msg'] = "<p class='text-danger'>Incorrect username or password</p>";
        }


    }

}





?>