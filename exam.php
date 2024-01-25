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

    if (isset($_SESSION["student_id"])) {
        $testId = $_SESSION['examId'];
        
        
        $sql = "SELECT * FROM test_questions_distinct;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $questions = array();
        
            // Fetch and structure the data into an array
            while ($row = $result->fetch_assoc()) {
                $questionId = $row["question_id"];
                $questionText = $row["question_text"];
                $optionId = $row["option_id"];
                $optionText = $row["option_text"];
                $isCorrect = $row["is_correct"];
            
                // Append options to the respective question
                if (!isset($questions[$questionId])) {
                    $questions[$questionId] = array(
                        "qid" => $questionId,
                        "qtxt" => $questionText,
                        "opts" => array()
                    );
                }
            
                $questions[$questionId]["opts"][] = array(
                    "oid" => $optionId,
                    "otxt" => $optionText,
                    "ans" => $isCorrect
                );
            }
            
        } else {
            echo "No questions found for the specified test.";
        }
    } 
    
    // $sql = "SELECT * FROM `tests` ORDER BY `test_date` DESC";
    // $result = $conn -> query($sql);
    // if($result -> num_rows > 0) {
    //     $data = $result -> fetch_assoc();
    //     $data = $data['test_date'];
    //     $dateString = '2023-11-06 20:06:00';
        
    //     // Create a DateTime object from the string
    //     $date = new DateTime($dateString);
    //     // Get the minutes from the DateTime object
    //     $minutes = $date->format('i');
    //     $data =  $minutes; // Output: 06
        
    //     $response['message'] = $data;

    //     echo json_encode($response);
    // }
    // else {
    //     die "Unothorised User!";
    // }
    
        
            // Convert the questions array to JSON
            $jsonResponse = json_encode(array_values($questions));
        
            // Send the JSON response to the front end
            header("Content-Type: application/json");
            echo $jsonResponse;
?>
