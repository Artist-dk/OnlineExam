<?php
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
    // print_r($_POST);
    if (isset($_SESSION["student_id"])) {
        if(isset($_POST)) {
            $student_id = $_SESSION['student_id'];
            $test_id = $_SESSION['examId'];

// Sample student answers and correct options
$studentAnswers = [1, 2, 3, 4, 5]; // Replace with actual student answers (selected_option_id)
$correctOptions = [2, 2, 3, 4, 5]; // Replace with actual correct options (option_id)

if (count($studentAnswers) !== count($correctOptions)) {
    echo "Error: The number of student answers does not match the number of correct options.";
} else {
    $totalQuestions = count($studentAnswers);
    $score = 0;

    for ($i = 0; $i < $totalQuestions; $i++) {
        if ($studentAnswers[$i] === $correctOptions[$i]) {
            $score++;
        }
    }

    // Calculate the percentage score
    $percentageScore = ($score / $totalQuestions) * 100;

    echo "Total Questions: $totalQuestions<br>";
    echo "Correct Answers: $score<br>";
    echo "Percentage Score: $percentageScore%";
}


            $sql = 'INSERT INTO test_results(student_id, test_id, score) VALUES('.$student_id.','.$_SESSION['examId'].','.$score.')';
            $result = $conn->query($sql);

            $jsonResponse = json_encode(array_values([$sql]));
        
            // Send the JSON response to the front end
            header("Content-Type: application/json");
            echo $jsonResponse;
            
            // if ($result->num_rows > 0) {
            //     $questions = array();
            
            //     // Fetch and structure the data into an array
            //     while ($row = $result->fetch_assoc()) {
            //         $questionId = $row["question_id"];
            //         $questionText = $row["question_text"];
            //         $optionId = $row["option_id"];
            //         $optionText = $row["option_text"];
            //         $isCorrect = $row["is_correct"];
                
            //         // Append options to the respective question
            //         if (!isset($questions[$questionId])) {
            //             $questions[$questionId] = array(
            //                 "qid" => $questionId,
            //                 "qtxt" => $questionText,
            //                 "opts" => array()
            //             );
            //         }
                
            //         $questions[$questionId]["opts"][] = array(
            //             "oid" => $optionId,
            //             "otxt" => $optionText,
            //             "ans" => $isCorrect
            //         );
            //     }
            
            //     // Convert the questions array to JSON
            //     $jsonResponse = json_encode(array_values($questions));
            
            //     // Send the JSON response to the front end
            //     header("Content-Type: application/json");
            //     echo $jsonResponse;
            // } else {
            //     echo "No questions found for the specified test.";
            // }
        }
  
    } 
    
    // else {
    //     die "Unothorised User!";
    // }
?>



