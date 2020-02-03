<?php

class DB {

    public $data = array();
    public $params = array();

    function __construct() {
        // run as soon as DB class is called 

        // store all our $_POST data in the $data variable
        if( !empty($_POST) ) {

            $conn = $this->conn();
            $escPost = array();
            foreach($_POST as $key => $value){
                $escPost[$key] = trim( mysqli_real_escape_string($conn, $value) );
            }
            $conn->close();
            $this->data = $escPost;

        }

        // store all our $_GET data in the $data variable
        if( !empty($_GET) ) {

            $conn = $this->conn();
            $escGet= array();
            foreach($_GET as $key => $value){
                $escGet[$key] = trim( mysqli_real_escape_string($conn, $value) );
            }
            $conn->close();
            $this->params = $escGet;

        }
    }

    protected function conn() {
        if($_SERVER['SERVER_NAME'] == "dev.scelterdesign.com") {
        $servername = 'localhost';
        $username = 'share_admin';
        $password = 'o&1Xpp14';
        $dbname = 'projectshare';
        } else {
        $servername = 'localhost';
        $username = 'root';
        $password = 'root';
        $dbname = 'projectshare';
        }

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }


    /*
    *   select
    *   run a sysql select staement and return the results 
    */

    public function select($sql) {
        if(APP_DEBUG) echo 'execute_return_id()<br>';
        $conn = $this->conn();
        $result = $conn->query($sql);

        // store the xss cleaned data
        // XSS = cross-site scripting attack
        $xssArr = array();
        if($result->num_rows > 0){
            $x = 0;
            while($row = $result->fetch_assoc()) {
                // loop through each column of the current row
                foreach($row as $column => $value){
                    $xssArr[$x][$column] = htmlspecialchars($value, ENT_QUOTES);
                }
                $x++;
            }
        } else {
            if(APP_DEBUG) $_SESSION['errors'][] = "Error selecting the database: $sql";
        }

        $conn->close();
        return $xssArr;
    }


    /*
    *  execute
    *  @params $sql
    *
    *  executes sql
    *  @returns null
    */
    public function execute($sql) {
        $conn = $this->conn();
        if($conn->query($sql) !== true) {
            echo "Your statement: ". $sql . "<br> Error: ".$conn->error;
            die("Error with the sql statement");
        }
        $conn->close();
    }



    // execute_return_id
    // @params $sql
    //
    // executes sql query and returns the last inserted ID
    // @returns int
    //

    public function execute_return_id($sql) {
        if(APP_DEBUG) echo 'execute_return_id()<br>';
        $conn = $this->conn();
       
        if( $conn->query($sql) !== TRUE ) {
            echo "Your statement: ". $sql . "<br> Error: ".$conn->error;
            die("Error with the sql statement");
        }
        $last_id = $conn->insert_id;

        $conn->close();

        return $last_id;

    }

}

?>