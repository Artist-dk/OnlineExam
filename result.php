

<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_db";

session_start();
// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$percentageScore = 0;

$sql = "SELECT sa.selected_option_id, o.is_correct, st.submission_date, t.subject, s.fname, s.lname
        FROM student_answers AS sa
        INNER JOIN options AS o ON sa.selected_option_id = o.option_id
        INNER JOIN submitted_tests AS st ON sa.student_id = st.student_id AND sa.test_id = st.test_id
        INNER JOIN tests AS t ON sa.test_id = t.test_id
        INNER JOIN students AS s ON sa.student_id = s.student_id
        WHERE sa.student_id = ? AND sa.test_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION['student_id'], $_SESSION['examId']);
$stmt->execute();
$result = $stmt->get_result();

$score = 0; // Initialize the score
$totalQuestions = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    if ($row['is_correct'] === 1) {
        // Increment the score for each correct answer (where is_correct is 1)
        $score++;
    }
    
    $submission_date = $row['submission_date']; // Get submission_date
    $subject = $row['subject']; // Get subject
    $studentName = $row['fname'] . ' ' . $row['lname']; // Get student name
}

$percentageScore = ($score / $totalQuestions) * 100;

// Access other data like submission_date and subject
if($percentageScore < 40) {
    $status = 'Fail';
    $resultMsg = 'Unfortunately, you did not pass the test.';
} else {
    $status = 'Pass';
    $resultMsg = 'Congratulations! You have successfully passed the test.';
}

// Create a DateTime object from the date string
$dateTime = new DateTime($submission_date);

// Format the date as 'F d, Y' (F stands for full month name, d for day, and Y for year)
$formattedDate = $dateTime->format('d F, Y');


echo json_encode(['success' => true, 'percentageScore' => round($percentageScore), 'score' => $score, 'date' => $formattedDate, 'subject' => $subject, 'studentName' => $studentName, 'status' => $status, 'resultMsg' => $resultMsg]);

$conn->close();
?>
