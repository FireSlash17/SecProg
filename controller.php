<?php
session_start();


$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "db";


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkLogin($email, $password) {
    global $conn;

    
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

   
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->prepare($query);

    
    if ($result->num_rows == 1) {
        return true; 
    } else {
        return false; 
    }
}

// if (isset($_SESSION['email'])) {
//     header("Location: home.php");
//     exit();
// }
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];
//     $_SESSION["hci"] = $email;

//   
//     print_r(checkLogin);
//     if (checkLogin($email, $password)) {
//         
//         $_SESSION["hci"] = $email;
//         header("Location: home.php");
//         exit();
//     } else {
//        
//         $error = "Invalid username or password";
//         exit();
//     }

// }
?>