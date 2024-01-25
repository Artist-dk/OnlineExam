<?php
// Your database connection code here

session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db";

// Establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $sql = "SELECT sa.selected_option_id, o.is_correct 
    FROM student_answers AS sa
    INNER JOIN options AS o ON sa.selected_option_id = o.option_id
    WHERE sa.student_id = ? AND sa.test_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_SESSION['student_id'], $_SESSION['examId']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $score = 0; // Initialize the score
    
    while ($row = $result->fetch_assoc()) {
        if ($row['is_correct'] === 1) {
            // Increment the score for each correct answer (where is_correct is 1)
            $score++;
        }
    }
    
    // Now $score contains the total score

    // Calculate the score based on the answers
    // $score = calculateScore($score);
    
    // Insert the results into the test_results table with the current timestamp
    
    $student_id = $_SESSION['student_id'];
    $test_id = $_SESSION['examId'];
    $query = $conn->prepare("SELECT * FROM submitted_tests WHERE student_id = ? AND test_id = ?");
    $query->bind_param("ii", $student_id, $test_id);
    $query->execute();
    $result = $query->get_result();
    $existingRecord = $result->fetch_assoc();
    
    // Free the result set
    $result->free();
    
    if ($existingRecord) {
        echo json_encode(['success' => false, 'message' => 'Exam already submitted.']);
    } else {
        // Insert a new record
        $insertQuery = $conn->prepare("INSERT INTO submitted_tests (test_id, student_id, submission_date, score) VALUES (?, ?, NOW(), ?)");
        $insertQuery->bind_param("iii", $_SESSION['examId'], $_SESSION['student_id'], $score);
        $insertQuery->execute();
        $insertQuery->close();
        echo json_encode(['success' => true, 'message' => 'Exam submitted successfully.', 'score' => $score]);
    }
    

    // // Insert the results into the test_results table
    // $sql = "INSERT INTO test_results (test_id, student_id, submission_date,  score) VALUES (?, ?, ?)";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("iii", $testId, $studentId, $score);
}

?>
