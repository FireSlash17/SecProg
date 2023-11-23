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

<h1>
    HOME
</h1>