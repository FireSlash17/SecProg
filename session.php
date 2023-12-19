<?php
function checkSessionValidation() {
    if (isset($_SESSION['logintime'])) {
        $session = time() - $_SESSION['logintime'];
        $sessionexpiration = 12 * 60 * 60;
        if ($session > $sessionexpiration) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['logintime'] = time();
        }
    }
}