<?php

include_once('./config/config.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the data from the request payload
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');  
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');  
  $mobile = htmlspecialchars($_POST['mobile'], ENT_QUOTES, 'UTF-8');  
  $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');  
  $emp_id = htmlspecialchars($_POST['empId'], ENT_QUOTES, 'UTF-8');  
  $sling_shot_id = htmlspecialchars($_POST['slingShotId'], ENT_QUOTES, 'UTF-8');  
  
  $photo = $_POST['photoPath'];

  // Generate a random number between 1 and 16
  $imgId = rand(1, 3);


  try {
      // Connect to the database
      $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Prepare and execute the SQL statement to insert the note into the database
      $stmt = $db->prepare('INSERT INTO '.$tableName.' (name, message, emp_id ,email, mobile, photo, img_id,sling_shot_id) VALUES (?, ?, ?, ?, ?, ?,?,?)');
      $stmt->execute([$name,$message,$emp_id,$email,$mobile, $photo, $imgId,$sling_shot_id]);

      // Return a success response
      http_response_code(200);
      echo 'Note saved successfully';
  } catch (PDOException $e) {
      // Return an error response
      http_response_code(500);
      echo 'Failed to save the note. Error: ' . $e->getMessage();
  }
} else {
  // Invalid request method
  $response = [
    'success' => false,
    'error' => 'Invalid request method.'
  ];
}

// Set the appropriate response headers
header('Content-Type: application/json');
// Encode the response as JSON
echo json_encode($response);
// Terminate the script to prevent any additional output
exit();
?>
