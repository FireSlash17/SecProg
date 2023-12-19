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
    <title>Home Page</title>
      <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="home.css">
  <body style="background-image: url('./truckhome.png'); background-size: cover;">
</head>
<body>
    <h1>HOME</h1>
    
    <!-- Your page content goes here -->
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>

    <!-- Logout Button -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
    <form action="chat.php" method="post">
        <input type="submit" value="Chat">
    </form>
</body>
</html>
<?php 
$sql = "SELECT sender_name, message, sent_at FROM messages ORDER BY sent_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Display each message
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p><strong>From:</strong> " . $row["sender_name"] . "</p>";
        echo "<p><strong>Message:</strong><br>" . $row["message"] . "</p>";
        echo "<p><strong>Sent At:</strong> " . $row["sent_at"] . "</p>";
        echo "</div>";
    }
} else {
    echo "No messages yet.";
}

$conn->close();
?>