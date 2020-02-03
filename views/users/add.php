<?php
/*  /users/add.php
*   handles the adding of new users to the database 
*/
require_once("../../controllers/includes.php");


// check if all fields are filled
// create a new user object 
// check if the user already exists in the database
// if not, add them to the database
// redirect to home page once added


if( !empty( $_POST['username'] ) && 
    !empty( $_POST['email'] ) && 
    !empty( $_POST['password'] ) &&
    !empty( $_POST['firstname'] ) &&
    !empty( $_POST['lastname'] ) &&
    !empty( $_POST['bio'] ) ) {

        // create a new user object
        $user = new User;

        // check if user already exists in the database
        echo 'lol ';
        $exists = $user->exists();

       

        if( empty($exists) ) {
            $new_user_id = $user->add();
            $_SESSION['user_logged_in'] = $new_user_id;
        } else {
            $_SESSION['create_account_msg'] = "<p class='text-danger'>User already exists</p>";
        }
        

    }


header("Location: /");

?>