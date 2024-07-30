<?php
include_once('./config/config.php');
$sling_id = $_GET['id'];
// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);

// Fetch the count of rows in the table
$query = $pdo->query("SELECT COUNT(*) as count FROM $tableName where sling_shot_id = $sling_id");
$result = $query->fetch(PDO::FETCH_ASSOC);

// Prepare the response as JSON
$response = array('count' => $result['count']);
header('Content-Type: application/json');
echo json_encode($response);
?>
