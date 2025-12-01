<?php
/**
 * Description: Logout user, destroy session and redirect to login page
 * 
 * File: logout.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

// Start session
session_start();

// Get username before destroying session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

// Destroy all session data
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to index.php (not login page)
header("Location: index.php?message=loggedOut");
exit;
?>