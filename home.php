<?php
session_start();
require_once "connectdb.php";
require_once "session.php";
if ($_SESSION['is login'] != true){
    header(Location : login.php);
    exit();
}
checkSessionValidation();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

    <form action="logout.php" method="post">
        <input type="submit" name="logout" value="Logout" class="btn btn-login font-weight-bold col-5">
    </form>

    <h1>HOME</h1>

</body>
</html>

