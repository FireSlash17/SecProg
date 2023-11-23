<?php
session_start();
require "connectdb.php";
require "session.php";

function login($email, $password) {
    global $conn;

    $query = "SELECT * FROM users WHERE email=?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}

?>