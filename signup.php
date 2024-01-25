<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Insert user data into the 'students' table
    $sql = "INSERT INTO students (fname, lname, phone, email, username, password)
            VALUES ('$fname', '$lname', '$phone', '$email', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // $_SESSION['username'] = $username;
        $response = array(
            'success' => true,
            'message' => 'Registration successful'
        );
        echo json_encode($response);
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
