<?php
include_once('./config/config.php');

// Get the timestamp parameter from the AJAX request
// $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

$sling_id = $_GET['id']; 

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to fetch the notes
$sql = "SELECT ID,name,photo,img_id,message FROM $tableName where sling_shot_id =$sling_id ORDER BY created_at DESC LIMIT 5 ";

// If a timestamp is provided, add a condition to select only the updated records
// if ($timestamp !== null) {
//     $sql .= " WHERE created_at > '$timestamp'";
// }

// Execute the SQL statement
$result = $conn->query($sql);
// Prepare an array to store the fetched notes
$notes = array();

// Check if there are any updated records
$updated = false;

// Fetch the notes from the result set
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add each note to the array
        $notes[] = array(
            'id' => $row['ID'],
            'photo' => $row['photo'],
            'name' => $row['name'],
            'img_id' => $row['img_id'],
            'message' => $row['message']
        );

        // Set the updated flag to true
        $updated = true;
    }
}

// Create a response object
$response = array(
    'updated' => $updated,
    'notes' => $notes,
    'timestamp' => time() // Get the current timestamp
);


// $response = array('notes'=>$notes);


// Convert the response to JSON format
$jsonResponse = json_encode($response);

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo $jsonResponse;

// Close the database connection
$conn->close();
?>
