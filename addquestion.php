<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

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
 
  
    // Insert the new question into the questions table
    $questionText = $data->questionText;
    $sql = "INSERT INTO questions (question_text) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $questionText);

    if ($stmt->execute()) {
        $questionId = $stmt->insert_id;
        $stmt->close();

        // Insert options and their correctness into the options table
        for ($i = 1; $i <= 4; $i++) {
            $optionText = $data->{"option$i"};
            $isCorrect = ($i == $data->correctOption) ? 1 : 0;
            
            $testId = $data->{"testId"};
            $sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $questionId, $optionText, $isCorrect);
            $stmt->execute();



        }
                    
        $sql = "INSERT INTO test_questions (test_id, question_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $testId, $questionId);
        $stmt->execute();
        
        $stmt->close();
        $conn->close();

        $response = [
            "success" => true,
            "message" => "Question added successfully.",
        ];
    } else {
        $conn->close();
        $response = [
            "success" => false,
            "message" => "Error while adding the question.",
        ];
    }

    echo json_encode($response);
} else {
    http_response_code(400); // Bad request
}
?>
