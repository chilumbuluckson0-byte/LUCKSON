<?php
// auth_session.php

// Start the session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user data not set, redirect to login (you can skip this line if not needed)
if (!isset($_SESSION['email'])) {
    // header("Location: login.php");
    // exit();
}

// Make session variables easy to access
$isLoggedIn = isset($_SESSION['email']);
$userEmail = $isLoggedIn ? $_SESSION['email'] : '';
$userName = $isLoggedIn ? $_SESSION['first_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['role'] : '';
?>
