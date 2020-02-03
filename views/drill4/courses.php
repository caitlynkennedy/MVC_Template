<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "root";
$database = "Drills";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";



////// UPDATE COURSE
if(!empty ($_POST['action']) && $_POST['action'] == 'Update'){
    $course_name = $_POST['course_name'];
    $instructor = $_POST['instructor'];
    $quarter = $_POST['quarter'];
    $id = $_POST['id'];

    $sql = "UPDATE courses 
            SET course_name = '$course_name', instructor = '$instructor', quarter = '$quarter'
            WHERE id = $id";
    $conn->query($sql);

}

////// END UPDATE COURSE



$courses_query = "SELECT * FROM courses"; //selects
$results = $conn->query($courses_query); // runs the query and stores in variable called $results

$courses_array = array(); // defining an empty array



?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<table id="courses_table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Course</th>
            <th scope="col">Instructor</th>
            <th scope="col">Quarter</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row = $results->fetch_assoc()){  //create row variable to store rows of results
            //$courses_array[] = $row; // store the row values in an array created above $cooler_array
            echo '<tr>';
            echo '<td>' .$row['id']. '</td>';
            echo '<td>' .$row['course_name']. '</td>';
            echo '<td>' .$row['instructor']. '</td>';
            echo '<td>' .$row['quarter']. '</td>';
            echo '<td><a href="?id='.$row["id"].'">Edit</a></td>';
            echo '</tr>';
           
        };

          ?>
        </tbody>
</table>
<?php
if(! empty($_GET['id'])) {
    $sql = "SELECT * FROM courses WHERE id = " . $_GET['id'];
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
    ?>
    <form  method="post">
        <table>
            <tr>
                <td><input type="text" placeholder="Course Name" name="course_name" value="<?=$row['course_name']?>"></td>
                <td><input type="text" placeholder="Instructor" name="instructor" value="<?=$row['instructor']?>"></td>
                <td><input type="text" placeholder="Quarter" name="quarter" value="<?=$row['quarter']?>"></td>
                <td>
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <input type="submit" name="action" value="Update">
                </td>
            </tr>
        </table>
    </form>
    <?php

    }
}





