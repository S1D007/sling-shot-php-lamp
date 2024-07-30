<?php
$filename = 'data.txt';

// Read POST data from the mobile device
$alpha = isset($_POST['alpha']) ? $_POST['alpha'] : 0;
$beta = isset($_POST['beta']) ? $_POST['beta'] : 0;
$gamma = isset($_POST['gamma']) ? $_POST['gamma'] : 0;
$tracker = isset($_POST['tracker']) ? $_POST['tracker'] : false;

// Prepare the orientation data
$orientationData = json_encode(array('alpha' => $alpha, 'beta' => $beta, 'gamma' => $gamma,'tracker' => $tracker)) . PHP_EOL;

// Write the data to the file (append mode)
file_put_contents($filename, $orientationData);

echo "Data written successfully.";
?>
