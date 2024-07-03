<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captcha = $_POST['captcha'];
    $_SESSION['captcha'] = $captcha;
}
?>
