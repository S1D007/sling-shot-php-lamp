<?php
// Check if a photo was uploaded
if(isset($_FILES['photo'])) {
  $photo = $_FILES['photo'];
  
  // Define the target directory to save the photo
  $targetDir = 'photos/';
  // Generate a unique filename for the photo
  $filename = uniqid() . '.jpg';
  // Build the target path for the photo
  $targetPath = $targetDir . $filename;
  
  // Move the uploaded photo to the target directory
  if(move_uploaded_file($photo['tmp_name'], $targetPath)) {
    // Photo saved successfully
    
    // Store the image path in the database (replace with your database code)
    $imagePath = $targetPath;
    // Connect to your database
    
    
    // Return the photo path in the response
    $response = [
      'success' => true,
      'photoPath' => $imagePath
    ];
  } else {
    // Error saving the photo
    $response = [
      'success' => false,
      'error' => 'Error saving the photo.'
    ];
  }
} else {
  // No photo uploaded
  $response = [
    'success' => false,
    'error' => 'No photo uploaded.'
  ];
}

// Set the appropriate response headers
header('Content-Type: application/json');
// Encode the response as JSON
echo json_encode($response);
// Terminate the script to prevent any additional output
exit();
?>
