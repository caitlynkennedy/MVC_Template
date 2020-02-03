<?php
require_once('../../../controllers/includes.php');
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

$courses_query = "SELECT * FROM courses"; //selects
$results = $db->query($sql); // runs the query and stores in variable called $results

$cooler_array = array(); // defining an empty array
while($row = $results->fetch_assoc()){  //create row variable to store rows of results
    $cooler_array[] = $row; // store the row values in an array created above $cooler_array
}


echo json_encode($cooler_array); // echoing the array and making readable by javascript (json_encode)



?>