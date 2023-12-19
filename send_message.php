<?php
include('connectdb.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senderName = $_POST['sender_name'];
    $message = $_POST['message'];

    // Insert message into the database
    $sql = "INSERT INTO messages (sender_name, message) VALUES ('$senderName', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body>

    <form action="home.php" method="post">
        <input type="submit" value="Home">

    </form>
</body>
</html>