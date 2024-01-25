<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db";

$data = json_decode(file_get_contents("php://input"), true);

$subject = $data['subject'];
$testDate = $data['testDate'];
$duration = $data['duration'];
$description = $data['description'];

// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Prepare and execute the SQL statement to insert a new test
$sql = "INSERT INTO tests (subject, test_date, duration_minutes, description) VALUES (:subject, :testDate, :duration, :description)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':subject', $subject);
$stmt->bindParam(':testDate', $testDate);
$stmt->bindParam(':duration', $duration);
$stmt->bindParam(':description', $description);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Test created successfully.";
} else {
    $response['success'] = false;
    $response['message'] = "Error creating the test: " . implode(', ', $stmt->errorInfo());
}
echo "hello";
echo json_encode($response);
?>
