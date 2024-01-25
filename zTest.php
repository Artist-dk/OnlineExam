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
        $response = array(
            'success' => false,
            'message' => 'Registration failed: '
        );
        // $username = $_POST["username"];
        // $password = $_POST["password"];
        
        // Insert user data into the 'students' table
        $sql = "SELECT * FROM `tests` ORDER BY `test_date` DESC";
        $result = $conn -> query($sql);
        if($result -> num_rows > 0) {
            $data = $result -> fetch_assoc();
            $data = $data['test_date'];

            $response['message'] = $data;

            echo json_encode($response);
            $dateString = '2023-11-06 20:06:00';
            $dateTime = new DateTime($dateString);
            $currentDateTime = date('Y-m-d H:i:s');
            
            $year = $dateTime->format('Y');     // Get the year
            $month = $dateTime->format('m');    // Get the month
            $day = $dateTime->format('d');      // Get the day
            $hours = $dateTime->format('H');    // Get the hours
            $minutes = $dateTime->format('i');  // Get the minutes
            $seconds = $dateTime->format('s');  // Get the seconds
            
            $minutes = date('H');

            $data = $minutes."----".$currentDateTime;
            $data .= "year: ".$year." month: ".$month." day: ".$day." hours: ".$hours;
        }
    // if ($conn->query($sql) == TRUE) {
    // } else {

    //     $response['message'] = $result;
    //     echo json_encode($response);
    // }
}
// Close the database connection
$conn->close();
?> 
