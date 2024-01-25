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
    $examId = $_POST["examId"];
    session_start();
    $_SESSION['examId']=$examId;
    // Insert user data into the 'students' table
    $sql = "SELECT test_id FROM tests WHERE test_id = $examId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Print the test ID
            $num = $row['test_id'];
            $int = (int)$num;
            $response = array(
                'success' => true,
                'message' => 'Registration successful! test_id: '.$num
            );
            echo json_encode($response);
        }    
    } else {
        $response = array(
            'success' => false,
            'message' => 'Registration failed!'
        );
        echo json_encode($response);
    }
    
    // $response = array(
    //     'success' => true,
    //     'message' => 'Registration successful',
    //     'query'=> $sql,
    //     'condition'=> $conn->query($sql)
    // );
    // echo json_encode($response);

    // if ($conn->query($sql) === TRUE) {
    //     // $_SESSION['username'] = $username;
    //     $response = array(
    //         'success' => true,
    //         'message' => 'Registration successful'
    //     );
    //     echo json_encode($response);
    // } else {
    //     $response = array(
    //         'success' => false,
    //         'message' => 'Registration failed: ' . $conn->error
    //     );
    //     echo json_encode($response);
    // }
    
}
// Close the database connection
$conn->close();
?> 
