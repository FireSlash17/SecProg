<?php
session_start();
require_once "connectdb.php";
require_once "session.php";
// if ($_SESSION['hci'] != true){
//    header(Location : 'login.php');
//     exit();
// }
// checkSessionValidation();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Page</title>
</head>
<body>
    <h1>Chat</h1>
    <form action="send_message.php" method="post">
        <label for="sender_name">Your Name:</label>
        <input type="text" id="sender_name" name="sender_name" required><br><br>
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br><br>
        
        <input type="submit" value="Send Message">
    </form>

    <!-- Button to go back without submitting the form -->
    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = 'home.php';
        }
    </script>
</body>
</html>