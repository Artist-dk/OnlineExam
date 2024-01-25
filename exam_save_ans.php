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
            $data = $_POST['data'];
            $data = json_decode($data, true);
            
            
            $student_id = $_SESSION['student_id'];
            $question_id = $data['qid']; 
            $selected_option_id = $data['aid']; 
            $test_id = $_SESSION['examId'];
            $query = $conn->prepare("SELECT * FROM student_answers WHERE student_id = ? AND question_id = ? AND test_id = ?");
            $query->bind_param("iii", $student_id, $question_id, $test_id);
            $query->execute();
            $result = $query->get_result();
            $existingRecord = $result->fetch_assoc();
            
            // Free the result set
            $result->free();
            
            if ($existingRecord) {
                // Update the existing record
                $updateQuery = $conn->prepare("UPDATE student_answers SET selected_option_id = ? WHERE student_id = ? AND question_id = ? AND test_id = ?");
                $updateQuery->bind_param("iiii", $selected_option_id, $student_id, $question_id, $test_id);
                $updateQuery->execute();
                $updateQuery->close();
            } else {
                // Insert a new record
                $insertQuery = $conn->prepare("INSERT INTO student_answers (student_id, question_id, selected_option_id, test_id) VALUES (?, ?, ?, ?)");
                $insertQuery->bind_param("iiii", $student_id, $question_id, $selected_option_id, $test_id);
                $insertQuery->execute();
                $insertQuery->close();
            }
            
            // Close the prepared statements
            $query->close();
            
            // $sql = 'INSERT INTO student_answers(student_id, selected_option_id, question_id,test_id) VALUES('.$student_id.', '.$data['aid'].', '.$data['qid'].','.$_SESSION['examId'].')';
            // $result = $conn->query($sql);

            // $jsonResponse = json_encode(array_values([$sql]));
            $jsonResponse = json_encode(array_values([]));
        
            // Send the JSON response to the front end

            header("Content-Type: application/json");
            // echo $jsonResponse;
            
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
