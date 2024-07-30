<?php

include_once('./config/config.php');

$sling_id = $_GET['id'];
// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to truncate the 'shot' table
$sql = "DELETE FROM table_name WHERE sling_shot_id = $sling_id";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Data deleted successfully";
} else {
    echo "Error truncating table: " . $conn->error;
}

// Close the connection
$conn->close();

?>
