<?php
session_start();
require "controller.php";
require "connectdb.php";
// global $conn;
// function emailexist($email) {
//     global $conn;

//     $query = "SELECT * FROM user WHERE email=?";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     return $result->num_rows > 0;
// }

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format";
        header("Location: regist.php");
        exit();
    }

    $query = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // $hashpw = hash('sha256', $password);
    // $randnum = mt_rand(1, 9999);
    if($result->num_rows > 0){
        $_SESSION['error_message']="Email sudah terdaftar";
        header("Location: regist.php");
        exit();
    }
    $query = "INSERT INTO user (email,password) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss",$email,$password);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registrasi berhasil.";
        header("Location: login.php");
    } else {
        $_SESSION['error_message'] = "Registrasi gagal";
        header("Location: regist.php");
    }

    $stmt->close();
} else {
    $_SESSION['error_message'] = "All fields are required";
    header("Location: regist.php");
}

$conn->close();
?>
