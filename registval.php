<?php
session_start();
require_once "connectdb.php";

function emailexist($email) {
    global $conn;

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format";
        header("Location: regist.php");
        exit();
    }

    if (emailexist($email)) {
        $_SESSION['error_message'] = "Email sudah terdaftar.";
        header("Location: regist.php");
        exit();
    }

    $hashpw = hash('sha256', $password);
    $randnum = mt_rand(1, 9999);

    $stmt = $conn->prepare("INSERT INTO users (email,password) VALUES (?,?)");
    $stmt->bind_param("ss",$email,$hashpw);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
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
