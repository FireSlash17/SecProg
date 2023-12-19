<?php
session_start();
require "controller.php";
require "session.php";

function login($email, $password) {
    global $conn;

    $query = "SELECT * FROM user WHERE email=?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email= ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    return $result;
}
$limit = 1;
$timeout = 300;
$ip = $_SERVER[‘REMOTE_ADDR’];
$cacheFile = ‘ddos_cache/’ . md5($ip);
$requests = @file_get_contents($cacheFile);
$lastAccessTime = @filemtime($cacheFile) ?: 0;
$elapsedTime = time () - $lastAccessTime;
If ($elapsedTime>$timeout){
    $requests = 0;
}

If ($requests >= $limit){
    http_response_code(429);
    die('Silahkan coba lagi nanti.');
}
file_put_contents($cacheFile, ++$requests);
touch($cacheFile);
session_start();

function isUserBlocked() {
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
        $block_time = 5 * 60; 
        $current_time = time();
        $last_attempt_time = isset($_SESSION['last_attempt_time']) ? $_SESSION['last_attempt_time'] : 0;

        if ($current_time - $last_attempt_time < $block_time) {
            return true; 
        } else {
            unset($_SESSION['login_attempts']);
            unset($_SESSION['last_attempt_time']);
            return false;
        }
    }

    return false;
}

function getUserCredentials($username) {

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "db";


    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }


    $query = "SELECT email, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();


    $stmt->close();
    $conn->close();

    return $row;
}

function login2($email, $password) {
    $credentials = getUserCredentials($email);


    if (isUserBlocked()) {
        echo "Anda telah diblokir. Silakan coba lagi setelah beberapa menit.";
        return;
    }


    if ($credentials && password_verify($password, $credentials['password'])) {

        unset($_SESSION['login_attempts']);
        unset($_SESSION['last_attempt_time']);
        echo "Login berhasil!";

    } else {

        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
        $_SESSION['last_attempt_time'] = time();
        echo "Login gagal. Coba lagi.";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    login($email, $password);
}
?>