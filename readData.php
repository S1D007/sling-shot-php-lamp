<?php
$filename = 'orientation.txt';

// Read the orientation data from the file
$orientationData = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!empty($orientationData)) {
  $latestData = end($orientationData);
  $latestOrientation = json_decode($latestData, true);
  echo json_encode($latestOrientation);
} else {
  echo json_encode(array('alpha' => 0, 'beta' => 0, 'gamma' => 0,'tracker' => false));
}
?>
