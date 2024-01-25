<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db";


session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Insert user data into the 'students' table
    $sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
    $result = $conn -> query($sql);
    if($result -> num_rows > 0) {
        $row = $result -> fetch_assoc();
        $_SESSION['student_id'] = $row['student_id'];
        $response = array(
            'success' => true,
            'message' => 'Registration successful'
        );
        echo json_encode($response);
    // }
    // if ($conn->query($sql) == TRUE) {
    } else {
        $response = array(
            'success' => false,
            'message' => 'Registration failed: ' . $conn->error
        );
        echo json_encode($response);
    }
}
// Close the database connection
$conn->close();
?> 
