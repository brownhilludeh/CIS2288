<?php
/**
 * Description: Checks if the user is logged in else redirect to login page
 * 
 * File: checkLoggedIn.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

//Checking for logged in sesison
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    // User is not logged in
    // Redirect user to login.php
    header("Location: login.php?message=notLoggedIn");
    exit;
}
?>