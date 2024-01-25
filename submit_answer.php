<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answer = json_decode(file_get_contents("php://input"), true);

    echo $_POST;
    session_start();
    
    [$student_id, $question_id, $selected_option_id, $test_id]
    // Assuming that the student is logged in, you should retrieve the student's ID from the session.
    // For this example, let's use a static student ID (you should implement the actual session logic).
    $student_id = $_SESSION['student_id']; // Replace with your logic to get the student's ID

    // Assuming the question number is sent from the client
    $question_id = 1; // Replace with your logic to get the question number

    // Assuming the option value is sent from the client
    $selected_option_id = $answer['selected_option_id'];

    $test_id = $_SESSION['test_id'];
    // Insert the student's answer into the database
    
    // Check if the record exists
    $query = $conn->prepare("SELECT * FROM student_answers WHERE student_id = ? AND question_id = ? AND selected_option_id = ? AND test_id = ?");
    $query->execute([$student_id, $question_id, $selected_option_id, $test_id]);
    $existingRecord = $query->fetch();

    
    if ($existingRecord) {
        // Record exists, update it
        $updateQuery = $conn->prepare("UPDATE student_answers SET selected_option_id = ? WHERE student_id = ? AND question_id = ? AND test_id = ?");
        $updateQuery->execute([$selectedOptionId, $studentId, $questionId, $test_id]);
    } else {
        // Record does not exist, insert it
        $insertQuery = $conn->prepare("INSERT INTO student_answers (student_id, question_id, selected_option_id, test_id) VALUES (?, ?, ?, ?)");
        $insertQuery->execute([$studentId, $questionId, $selectedOptionId, $test_id]);
    }


    // $sql = "SELECT * FROM student_answers WHERE student_id = '".$studentId."' AND question_id = '".$questionNumber."' AND selected_option_id = '".$selectedOption."'";

    // $sql = "INSERT INTO student_answers (student_id, question_id, selected_option_id) VALUES ($studentId, $questionNumber, $selectedOption)";

    // if ($conn->query($sql) === TRUE) {
    //     $response = array('success' => true, 'message' => 'Answer submitted successfully.');
    // } else {
    //     $response = array('success' => false, 'message' => 'Error submitting answer: ' . $conn->error);
    // }

    echo json_encode($response);
}

$conn->close();
?>
