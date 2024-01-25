<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, 'joker');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


header("Content-Type: application/json; charset=UTF-8");
$data=json_decode($_POST["data"], true);
// print_r($data);

// print($data['fname']);
// echo $_POST['fname'];
// echo $_POST['lname'];
// echo $_POST['username'];
// echo $_POST['password'];
// echo $_POST['phone'];
// echo $_POST['email'];
session_start();

// echo $_POST['phone'];
if(isset($data['fname']) && isset($data['lname']) && isset($data['username']) && isset($data['phone']) && isset($data['email']) && isset($data['password'])) {
    if(is_numeric($data['phone'])) {
        // insert into users (username, password, fname, lname, phone, email) values ('Artist', 'abc$1234','digambar','kumbhar','9988776655','abcdefghijklmnopqrstuvwxyz@gmail.com');
        $sql =  "INSERT INTO users (username,password,fname,lname,phone,email) VALUES ('".mysqli_real_escape_string($conn ,$data['username'])."', PASSWORD('".mysqli_real_escape_string($conn ,$data['password'])."'), '".mysqli_real_escape_string($conn ,$data['fname'])."', '".mysqli_real_escape_string($conn ,$data['lname'])."', ".mysqli_real_escape_string($conn ,$data['phone']).", '".mysqli_real_escape_string($conn ,$data['email'])."')";
        // echo $sql;
        mysqli_query($conn, $sql);
        $sql = "SELECT id FROM users WHERE username = '".mysqli_real_escape_string($conn ,$data['username'])."' AND password = PASSWORD('".mysqli_real_escape_string($conn ,$data['password'])."')";
        $result = $conn -> query($sql);
        // print_r($result);
        if($result -> num_rows > 0) {
            // print_r($result -> fetch_assoc());
            $row = $result -> fetch_assoc();
            $_SESSION['user_id'] = $row['user_id'];
            print("exam.html");
        } else {
            print('err');
        }
        // $_SESSION['user_id'] = $row['user_id'];
        // print("exam.html");
    }
}
// mysqli_free_result($result);
$conn -> close();


?>