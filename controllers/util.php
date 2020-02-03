<?php
class Util extends DB {


    public function file_upload($target_dir = APP_ROOT . "/views/uploads/" , $inputNameAttr = "fileToUpload") {

        // return an array of errors, or the filename on success

        $file_upload = array(
            'file_upload_error_status' => 0,
            'errors' => array(),
            'filename' => ''
        );

        // if the $_FILES input exists
        if( !empty($_FILES[$inputNameAttr]['name']) ) {

            // check if user folder exists 
            if(!file_exists( $target_dir . $_SESSION['user_logged_in'])){
                mkdir($target_dir . $_SESSION['user_logged_in']);
            }
            
            $filename = time() . basename($_FILES[$inputNameAttr]['name']);
            $target_file = $target_dir . $_SESSION['user_logged_in'] . "/" . $filename;

            // checks the image size, but if not an image will return an error
            $check = getimagesize($_FILES[$inputNameAttr]["tmp_name"]);
            if($check !== false) {
                $file_upload['file_upload_error_status'] = 0;
            } else {
                $file_upload['file_upload_error_status'] = 1;
                $file_upload['errors'][] = "File is not an image.";
            }

            // if file exists 
            if(file_exists($target_file)) {
                $file_upload['file_upload_error_status'] = 1;
                $file_upload['errors'][] = "File already exists.";
            }

            // check the file size
            $allowedSize = 10000000000;
            if($_FILES[$inputNameAttr]['size'] > $allowedSize) {
                $file_upload['file_upload_error_status'] = 1;
                $file_upload['errors'][] = "File is too big. Limit is " . ($allowedSize / 1000000) . "MB";
            }

            // check the file type 
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $valid_file_types = array('jpg', 'png', 'jpeg', 'gif');
            if(!in_array($file_type, $valid_file_types)) {
                $file_upload['file_upload_error_status'] = 1;
                $file_upload['errors'][] = "Only JPG, PNG, or GIF is allowed.";
            }

            // if no errors, upload
            if($file_upload['file_upload_error_status'] == 0) {

                if(move_uploaded_file($_FILES[$inputNameAttr]['tmp_name'], $target_file)) {
                    $file_upload['filename'] = mysqli_real_escape_string($this->conn(), str_replace(APP_ROOT.'/views', '', $target_file));

                    return $file_upload;
                }
            } else {
                $_SESSION['errors'] = $file_upload['errors'];
            }

            return $file_upload;
            
        }

    }
    
}

?>