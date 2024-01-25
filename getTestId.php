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
        $sql = "SELECT MAX(test_id) FROM tests";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Print the test ID
                $num = $row['MAX(test_id)'];
                $int = (int)$num;
                $int = $int+1;
                print_r($int);
            }
        } else {
            echo "0";
        }
    } 
    // else {
    //     die "Unothorised User!";
    // }
?>
