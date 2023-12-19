<?php
session_start();


if (
    isset($_POST['csrf_token']) &&
    isset($_SESSION['csrf_token']) &&
    hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
   
} else {
  
    echo "CSRF Token Validation Failed!";
}
// Set the maximum number of login attempts and lockout duration
$maxAttempts = 3; // Maximum number of attempts allowed
$lockoutDuration = 60 * 5; // Lockout duration in seconds (e.g., 5 minutes)

// ... (Other necessary includes or database connections)
require_once "connectdb.php";
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user has already exceeded the maximum attempts
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $maxAttempts) {
        // Check if the lockout period has passed
        if (isset($_SESSION['lockout_time']) && $_SESSION['lockout_time'] > time() - $lockoutDuration) {
            // User is still within the lockout duration
            // Handle lockout (e.g., display a message or redirect to a lockout page)
            echo "You've exceeded the maximum login attempts. Please try again later.";
            exit;
        } else {
            // Lockout duration has passed, reset login attempts
            unset($_SESSION['login_attempts']);
            unset($_SESSION['lockout_time']);
        }
    }

    // Example authentication logic (check email and password from the database)
    $inputEmail = $_POST['email'];
    $inputPassword = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $inputEmail);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($inputPassword, $hashedPassword)) {
        // Successful login
        // Clear login attempts on successful login
        unset($_SESSION['login_attempts']);
        unset($_SESSION['lockout_time']);

        // Redirect to the dashboard or any other authenticated page
        header("Location: dashboard.php");
        exit;
    } else {
        // Failed login attempt
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }

        // Check if the maximum attempts reached to set lockout time
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            $_SESSION['lockout_time'] = time();
        }

        // Handle incorrect credentials (e.g., display an error message)
        echo "Invalid email or password. Please try again.";
    }
} else {
    // Redirect or handle other HTTP methods (e.g., GET requests to this page)
}

?>