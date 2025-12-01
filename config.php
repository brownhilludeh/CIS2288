<?php 
/**
 * Description: Configuration file for Book Management System
 * 
 * File: config.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

// Sir please you can uncomment the following lines for your testing
//Database connection parameters
// $dbHost = "localhost";
// $dbUsername = "web_only_user";
// $dbPassword = "web_secret_password";
// $dbName = "books";

// Sir please you can uncomment the following lines for local testing
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "booking";

//Creating database(MySQL) connection
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//Checking connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

//Setting charset
$mysqli->set_charset("utf8");
?>