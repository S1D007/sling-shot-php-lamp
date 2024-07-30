<?php
// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['image'])) {
    // Extract the base64 encoded data
    $imgData = $data['image'];
    
    // Remove the data URL part
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    
    // Decode the base64 data
    $decodedImg = base64_decode($imgData);
    
    // Define the file path and name
    $filePath = './images/';
    $fileName = uniqid() . '.png';
    $fullPath = $filePath . $fileName;
    
    // Save the image file
    if (file_put_contents($fullPath, $decodedImg)) {
        echo json_encode(['status' => 'success', 'message' => 'Image saved successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save image!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No image data received!']);
}
?>
