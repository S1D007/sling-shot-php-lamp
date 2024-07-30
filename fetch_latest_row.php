<?php
include_once('./config/config.php');

$sling_id = $_GET['id'];
// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);

// Fetch the latest row from the table
$query = $pdo->query("SELECT * FROM $tableName WHERE created_at = (SELECT MAX(created_at) FROM $tableName where sling_shot_id = $sling_id) and sling_shot_id =$sling_id");
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// Prepare the response as JSON
$response = $result ? $result : array(); // Return an empty array if no rows found
header('Content-Type: application/json');
echo json_encode($response);
?>
